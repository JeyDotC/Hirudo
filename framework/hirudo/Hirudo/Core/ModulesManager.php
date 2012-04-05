<?php

namespace Hirudo\Core;

use Hirudo\Core\DependencyInjection\AnnotationLoader as AnnotationLoader;
use Hirudo\Core\Exceptions\ModuleNotFoundException;
use Hirudo\Core\Context as Context;
use Hirudo\Core\Context\ModuleCall;
use Hirudo\Lang\Loader as Loader;

/**
 * Description of ModulesManager
 *
 * @author JeyDotC
 */
class ModulesManager {

    private $context;
    private $rootAppDir;

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
        $this->rootAppDir = $this->context->getConfig()->get("businessRoot");
    }

    public function run() {
        $call = $this->context->getRequest()->buildModuleCall();
        $this->context->setCurrentCall($call);

        $module = $this->resolveModule($call);
        $this->dependencyManager->resolveDependencies($module);

        $module->setAppName($call->getApp());

        $task = $module->getTask($call->getTask());
        $this->resolveTaskRequirements($task);

        $task->invoke($module);
        echo $module->getRendered();
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
        if (is_file($file)) {
            require_once $file;
            return new $className();
        } else {
            throw new ModuleNotFoundException($call->getModule(), $call->getApp());
        }
    }

    private function getFileFromCall(ModuleCall $call) {
        return Loader::toSinglePath("{$this->rootAppDir}::{$call->getApp()}::Modules::{$call->getModule()}::{$call->getModule()}");
    }

    private function getClassNameFromCall(ModuleCall $call) {
        return "{$call->getApp()}\\Modules\\{$call->getModule()}";
    }

}

?>
