<?php

namespace Hirudo\Core;

/**
 * «Copyright 2012 Jeysson José Guevara Mendivil(JeyDotC)» 
 * 
 * This file is part of Hirudo.
 * 
 * Hirudo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 *  Hirudo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 * 
 *  You should have received a copy of the GNU General Public License
 *  along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */
use Hirudo\Core\DependencyInjection\AnnotationsBasedDependenciesManager;
use Hirudo\Core\Exceptions\ModuleNotFoundException;
use Hirudo\Core\Context as Context;
use Hirudo\Core\Context\ModuleCall;
use Hirudo\Lang\Loader;
//use Hirudo\Core\Events\BeforeTaskEvent;
//use Hirudo\Core\Events\HirudoStartEvent;
use Hirudo\Core\Exceptions\HirudoException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\ClassLoader\UniversalClassLoader;
use Symfony\Component\Yaml\Yaml;

/**
 * This class serves as a front controller in Hirudo, is the main entry
 * point of the framework.
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
     * Small optimization for enviroments where is highly probable to call
     * various tasks in the same module.
     * 
     * @var array<Module>
     */
    private static $loadedModules = array();

    /**
     *
     * @var AnnotationsBasedDependenciesManager
     */
    private $dependencyManager;

    /**
     * Creates a new modules manager. 
     * 
     * @param array<string> $implementationClasses A list of fully qualified 
     * class names that implement the core functionalities of Hirudo.
     */
    function __construct(array $implementationClasses) {
        $this->dependencyManager = new AnnotationsBasedDependenciesManager();
        $this->dependencyManager->addServices($implementationClasses);
        $this->context = Context\ModulesContext::instance();
        $this->context->setDependenciesManager($this->dependencyManager);
        $this->load();
    }

    private function load() {
        $this->dependencyManager->resolveDependencies($this->context);
        $this->loadExtensions();
        $this->rootAppDir = $this->context->getConfig()->get("businessRoot", "src");
    }

    /**
     * Executes the requested action based on the request parameters or the
     * default configuration.
     * 
     * @return string The program's output. 
     */
    public function run() {
        //Get the call from request.
        $call = $this->context->getRequest()->buildModuleCall();

        if ($call->isEmpty()) {
            $call = $this->getDefaultCall();
        }

        if (!$this->moduleExists($call)) {
            $call = $this->getModuleNotFoundCall();
        }

//        $this->dispatch(HirudoStartEvent::NAME, new HirudoStartEvent());

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

    /**
     * Executes a ModuleCall.
     * 
     * @param ModuleCall $call The call to be executed.
     * @return string The resulting output.
     */
    public function executeCall(ModuleCall $call) {
        //Register the applications namespace
        self::$autoLoader->registerNamespace($call->getApp(), Loader::toSinglePath($this->rootAppDir, ""));
        
        //Sets the current call in context. Possible useless behavior?
        $this->context->setCurrentCall($call);

        //Constructs the current module.
        $module = $this->resolveModule($call);

        $task = $module->getTask($call->getTask());
        $this->resolveTaskRequirements($task);

//        $event = new BeforeTaskEvent($task, $call);
//        $this->dispatch(BeforeTaskEvent::NAME, $event);

//        if ($event->getCallReplaced()) {
//            return $this->executeCall($event->getCall());
//        }

        $task->invoke();
        return $module->getRendered();
    }

    /**
     * Sets the autoloader class.
     * 
     * @param type $loader 
     */
    public static function setAutoLoader($loader) {
        self::$autoLoader = $loader;
    }

    /**
     * Resolves the task's requirements from request.
     * 
     * @param Task $task
     * @throws Exception 
     */
    protected function resolveTaskRequirements(Task &$task) {
        if ($task->isPostOnly() && $this->context->getRequest()->method() != "POST") {
            throw new \Exception("The task [{$this->context->getCurrentCall()}] accepts POST requests only");
        }

        foreach ($task->getGetParams() as /* @var $param \ReflectionParameter */$param) {
            $task->setParamValue($param->name, $this->context->getRequest()->get($param->name, $task->getParamValue($param->name)));
        }

        foreach ($task->getPostParams() as /* @var $param ReflectionParameter */$param) {
            if ($param->getClass() != null) {
                $object = $param->getClass()->newInstance();
                $this->context->getRequest()->bind($object, $this->context->getRequest()->post($param->name));
                $task->setParamValue($param->name, $object);
            } else {
                $task->setParamValue($param->name, $this->context->getRequest()->post($param->name, $task->getParamValue($param->name)));
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
        $className = $this->getClassNameFromCall($call);
        if (!isset(self::$loadedModules[$className])) {
            $module = new $className();
            $this->dependencyManager->resolveDependencies($module);
            self::$loadedModules[$className] = $module;
        }
        return self::$loadedModules[$className];
    }

    private function moduleExists(ModuleCall $call) {
        $file = $this->getFileFromCall($call);
        return is_file($file);
    }

    private function getFileFromCall(ModuleCall $call) {
        return Loader::toSinglePath("{$this->rootAppDir}::{$call->getApp()}::Modules::{$call->getModule()}::{$call->getModule()}");
    }

    private function getClassNameFromCall(ModuleCall $call) {
        return "{$call->getApp()}\\Modules\\{$call->getModule()}\\{$call->getModule()}";
    }

    /**
     *
     * @return ModuleCall
     */
    private function getDefaultCall() {
        $defaultValue = $this->context->getConfig()->get("onModuleNotFound");
        return ModuleCall::fromString($this->context->getConfig()->get("defaultModule", $defaultValue));
    }

    private function getModuleNotFoundCall() {
        return ModuleCall::fromString($this->context->getConfig()->get("onModuleNotFound"));
    }

    /**
     *
     * @return ModuleCall
     */
    private function getErrorCall() {
        return ModuleCall::fromString($this->context->getConfig()->get("onError"));
    }

    private function loadExtensions() {
        $extensions = $this->getExtensionsConfiguration();

        foreach ($extensions as $dir => $extension) {
            if (isset($extension["namespaces"])) {
                $this->registerNamespaces($dir, $extension["namespaces"]);
            }

            if (isset($extension["plugins"])) {
//                $this->registerPlugins($extension["plugins"]);
            }

            if (isset($extension["services"])) {
                $this->registerServices($extension["services"]);
            }

            if (isset($extension["templating_extensions"])) {
                $this->registerTemplatingExtensions($dir, $extension["templating_extensions"]);
            }
        }
    }

    private function registerNamespaces($dir, array $namespaces) {
        foreach ($namespaces as $key => $value) {
            $folder = $dir;
            $namespace = $value;

            if (is_string($key)) {
                $folder = $value;
                $namespace = $key;

                if (!is_dir($value)) {
                    $folder = Loader::toSinglePath($folder, "");
                }
            }
            self::$autoLoader->registerNamespace($namespace, $folder);
        }
    }

    private function registerPlugins(array $plugins) {
        foreach ($plugins as $plugin) {
            $this->addSubscriber(new $plugin());
        }
    }

    private function registerServices(array $services) {
        $this->dependencyManager->addServices($services);
    }

    private function registerTemplatingExtensions($dir,
            array $templating_extensions) {

        foreach ($templating_extensions as $extensionDir) {
            $this->context->getTemplating()->addExtensionsPath($dir . DS . $extensionDir);
        }
    }

    private function getExtensionsConfiguration() {
        $cacheFile = Loader::toSinglePath("ext::cache::extensions.config.cache", ".yml");
        $extensions = array();

        if ($this->context->getConfig()->get("debug") || !is_file($cacheFile)) {
            $extensionsDir = new \Hirudo\Lang\DirectoryHelper(new \RecursiveDirectoryIterator(Loader::toSinglePath("ext::libs", "")));
            $files = $extensionsDir->listDirectories(1);

            foreach ($files as $file) {
                if (is_file($file . DS . "manifest.yml")) {
                    $extensions[$file] = Yaml::parse($file . DS . "manifest.yml");
                }
            }
            if (!Loader::isDir("ext::cache")) {
                mkdir(Loader::toSinglePath("ext::cache", ""));
            }

            $yaml = Yaml::dump($extensions);
            file_put_contents($cacheFile, $yaml);
        } else {
            $extensions = Yaml::parse($cacheFile);
        }

        return $extensions;
    }

}

?>
