<?php

namespace Hirudo\Core;

use Hirudo\Core\DependencyInjection\AnnotationLoader as AnnotationLoader;
use Hirudo\Core\Exceptions\ModuleNotFoundException;
use Hirudo\Core\Context as Context;
use Hirudo\Core\Context\ModuleCall;
use Hirudo\Lang\Loader as Loader;
use Hirudo\Core\Events\BeforeTaskEvent;
use Hirudo\Core\Exceptions\HirudoException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\ClassLoader\UniversalClassLoader;

/**
 * Description of ModulesManager
 *
 * @author JeyDotC
 */
class ModulesManager extends EventDispatcher {

    /**
     *
     * @var Context\ModulesContext 
     */
    private $context;
    /**
     *
     * @var string The name of the root app dir.
     */
    private $rootAppDir;
    /**
     *
     * @var UniversalClassLoader 
     */
    private static $autoLoader;

    /**
     *
     * @var AnnotationLoader
     */
    private $dependencyManager;

    function __construct(array $implementationClasses) {
        $this->dependencyManager = new AnnotationLoader();
        $this->dependencyManager->addServices($implementationClasses);
        $this->context = Context\ModulesContext::instance();
        $this->load();
    }

    private function load() {
        $this->dependencyManager->resolveDependencies($this->context);
        $this->rootAppDir = $this->context->getConfig()->get("businessRoot", "src");

        $plugins = Loader::toPaths("ext::plugins::*");
        foreach ($plugins as $plugin) {
            require_once $plugin;
            $className = str_replace(".php", "", $plugin);
            $className = substr($className, strrpos($className, DS));
            $this->addSubscriber(new $className());
        }
    }

    /**
     * 
     * @return string The programs output. 
     */
    public function run() {
        //Get the call from request.
        $call = $this->context->getRequest()->buildModuleCall();
        
        if (!$this->moduleExists($call)) {
            $call = $this->getDefaultCall();
        }
        
        $output = "";

        try {
            $output = $this->executeCall($call);
        } catch (\Exception $ex) {
            $lastUnhandledException = $ex instanceof HirudoException ? $ex : new HirudoException($call, "", $ex);

            $errorCall = $this->getErrorCall();
            $errorCall->setLastUnhandledException($lastUnhandledException);

            $output = $this->executeCall($errorCall);
        }

        return $output;
    }

    public function executeCall(ModuleCall $call) {
        //Register the applications namespace
        self::$autoLoader->registerNamespace($call->getApp(), Loader::toSinglePath("$this->rootAppDir", ""));
        //Sets the current call in context possible useless behavior?
        $this->context->setCurrentCall($call);

        //Constructs the current module.
        $module = $this->resolveModule($call);
        $this->dependencyManager->resolveDependencies($module);
        $module->setAppName($call->getApp());

        $task = $module->getTask($call->getTask());
        $this->resolveTaskRequirements($task);

        $event = new BeforeTaskEvent($task, $call);
        $this->dispatch(BeforeTaskEvent::NAME, $event);

        if ($event->getCallReplaced()) {
            return $this->executeCall($event->getCall());
        }

        $task->invoke($module);
        return $module->getRendered();
    }
    
    public static function setAutoLoader($loader) {
        self::$autoLoader = $loader;
    }

    private function resolveTaskRequirements(Task &$task) {
        foreach ($task->getGetParams() as /* @var $param \ReflectionParameter */$param) {
            $task->setParamValue($param->name, $this->context->getRequest()->get($param->name, $task->getParamValue($param->name)));
        }

        foreach ($task->getPostParams() as /* @var $param ReflectionParameter */$param) {
            if ($param->isArray()) {
                $task->setParamValue($param->name, $this->context->getRequest()->post($param->name, $task->getParamValue($param->name)));
            } else {
                $object = $param->getClass()->newInstance();
                $this->context->getRequest()->bind($object, $this->context->getRequest()->post($param->name));
                $task->setParamValue($param->name, $object);
            }
        }
    }

    /**
     *
     * @param ModuleCall $call
     * @return \Hirudo\Core\Module
     * @throws ModuleNotFoundException 
     */
    private function resolveModule(ModuleCall $call) {
        $file = $this->getFileFromCall($call);
        $className = $this->getClassNameFromCall($call);
        require_once $file;
        return new $className();
    }

    private function moduleExists(ModuleCall $call) {
        $file = $this->getFileFromCall($call);
        return is_file($file);
    }

    private function getFileFromCall(ModuleCall $call) {
        return Loader::toSinglePath("{$this->rootAppDir}::{$call->getApp()}::Modules::{$call->getModule()}::{$call->getModule()}");
    }

    private function getClassNameFromCall(ModuleCall $call) {
        return "{$call->getApp()}\\Modules\\{$call->getModule()}";
    }

    /**
     *
     * @return ModuleCall
     */
    private function getDefaultCall() {
        return ModuleCall::fromString($this->context->getConfig()->get("onModuleNotFound"));
    }

    /**
     *
     * @return ModuleCall
     */
    private function getErrorCall() {
        return ModuleCall::fromString($this->context->getConfig()->get("onError"));
    }

}

?>
