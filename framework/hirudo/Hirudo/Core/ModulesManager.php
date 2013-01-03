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
use Hirudo\Core\Context as Context;
use Hirudo\Core\Context\ModuleCall;
use Hirudo\Core\DependencyInjection\AnnotationsBasedDependenciesManager;
use Hirudo\Core\Events\BeforeTaskEvent;
use Hirudo\Core\Events\Dispatcher\FileCachedHirudoDispatcher;
use Hirudo\Core\Events\Dispatcher\HirudoDispatcher;
use Hirudo\Core\Exceptions\HirudoException;
use Hirudo\Core\Exceptions\ModuleNotFoundException;
use Hirudo\Core\Module;
use Hirudo\Lang\DirectoryHelper;
use Hirudo\Lang\Loader;
use RecursiveDirectoryIterator;
use Symfony\Component\ClassLoader\UniversalClassLoader;
use Symfony\Component\Yaml\Yaml;

/**
 * This class serves as a front controller in Hirudo, is the main entry
 * point of the framework.
 *
 * @author JeyDotC
 */
class ModulesManager {

    /**
     *
     * @var Context\ModulesContext 
     */
    private $context;

    /**
     *
     * @var UniversalClassLoader 
     */
    private static $autoLoader;
    private $loadedApps = array();

    /**
     * Creates a new modules manager. 
     * 
     * @param array<string> $implementationClasses A list of fully qualified 
     * class names that implement the core functionalities of Hirudo.
     */
    function __construct($implementationPackage = "standalone") {
        $config = $this->loadFrameworkLevelConfiguration($implementationPackage);

        $dependencyManager = new $config["metadata_manager"]();
        $dependencyManager->addServices($config["implementation_package"]);
        $this->context = Context\ModulesContext::instance();
        
        $dependencyManager->resolveDependencies($this->context);
        $this->context->setDependenciesManager($dependencyManager);
        $this->context->getConfig()->loadValues($config);
        
        if ($this->context->getConfig()->get("enviroment") == "dev") {
            $this->context->setDispatcher(new HirudoDispatcher());
        } else {
            $this->context->setDispatcher(new FileCachedHirudoDispatcher(Loader::toSinglePath("ext::cache::listeners", "")));
        }
        
        //Loading global extensions...
        $this->loadExtensions("ext::libs");
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

        try {
            $output = $this->executeCall($call);
        } catch (\Exception $ex) {
            $unhandledException = $ex instanceof HirudoException ? $ex : new HirudoException($call, "", $ex);
            $errorEvent = $this->context->getDispatcher()->dispatch("taskError", new Events\TaskErrorEvent($unhandledException));
            $output = $errorEvent->getResult();
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
        if ($call->isEmpty()) {
            $call = $this->getDefaultCall();
        }
        
        $this->prepareApplication($call->getApp());

        if (!$this->moduleExists($call)) {
            $call = $this->getModuleNotFoundCall();
        }

        //Sets the current call in context. Possible useless behavior?
        $this->context->setCurrentCall($call);

        //Constructs the current module.
        $module = $this->resolveModule($call);

        $task = $module->getTask($call->getTask());

        $beforeTaskEvent = $this->context->getDispatcher()->dispatch("beforeTask", new BeforeTaskEvent($task));

        if ($beforeTaskEvent->isCallReplaced()) {
            return $this->executeCall($beforeTaskEvent->getCall());
        }

        $result = $task->invoke();
        $afterTaskEvent = $this->context->getDispatcher()->dispatch("afterTask", new Events\AfterTaskEvent($result));
        return $afterTaskEvent->getTaskResult();
    }

    private function loadFrameworkLevelConfiguration($implementationPackage = "standalone") {
        $frameworkLevelConfiguration = Yaml::parse(Loader::toSinglePath("ext::config::Config", ".yml"));
        $enviroment = Yaml::parse(Loader::toSinglePath("ext::config::{$frameworkLevelConfiguration["enviroment"]}.$implementationPackage", ".yml"));
        $config = array_merge($frameworkLevelConfiguration, $enviroment);
        return $config;
    }

    private function prepareApplication($appName) {
        if (array_search($appName, $this->loadedApps) === false) {
            $appPath = Loader::toSinglePath($appName, "");
            
            if (empty($appPath) || !file_exists($appPath)) {
                $appName = $this->context->getConfig()->get("defaultApplication");
                if(empty($appName)){
                    throw new \Exception("Application not found and no default application is setup. You can set a default application at the 'ext/config/Config.yml' file by adding this line: defaultApplication: ApplicationName");
                }
                $this->prepareApplication($appName);
                return;
            }
            
            self::$autoLoader->registerNamespace($appName, dirname($appPath));

            $dir = new DirectoryHelper(new RecursiveDirectoryIterator($appPath . DS . "Modules"));
            $files = $dir->listFiles(2, ".php", true, true);

            foreach ($files as $class) {
                $this->context->getDispatcher()->subscribeObject("$appName\Modules\\{$class}\\{$class}");
            }

            $this->loadedApps[] = $appName;
            $this->loadExtensions("$appName::ext::libs");
        }

        $this->context->getConfig()->loadApp($appName);
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
     * 
     * @return UniversalClassLoader
     */
    public static function getAutoLoader() {
        return self::$autoLoader;
    }

    /**
     * 
     * @param ModuleCall $call
     * @return Module
     * @throws ModuleNotFoundException 
     */
    private function resolveModule(ModuleCall $call) {
        $className = $this->getClassNameFromCall($call);
        return Util\ModulesRegistry::loadModule($className, true);
    }

    private function moduleExists(ModuleCall $call) {
        $file = $this->getFileFromCall($call);
        return is_file($file);
    }

    private function getFileFromCall(ModuleCall $call) {
        return Loader::toSinglePath("{$call->getApp()}::Modules::{$call->getModule()}::{$call->getModule()}");
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

    private function loadExtensions($extLibs) {
        $extensions = $this->getExtensionsConfiguration($extLibs);

        foreach ($extensions as $dir => $extension) {
            if (!isset($extension["active"]) || $extension["active"]) {
                if (isset($extension["includes"])) {
                    $this->includeLibraries($dir, $extension["includes"]);
                }

                if (isset($extension["namespaces"])) {
                    $this->registerNamespaces($dir, $extension["namespaces"]);
                }

                if (isset($extension["plugins"])) {
                    $this->registerPlugins($extension["plugins"]);
                }

                if (isset($extension["services"])) {
                    $this->registerServices($extension["services"]);
                }

                if (isset($extension["templating_extensions"])) {
                    $this->registerTemplatingExtensions($dir, $extension["templating_extensions"]);
                }
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
            if (is_string($plugin)) {
                $this->context->getDispatcher()->subscribeObject(new $plugin());
            } else if (is_array($plugin) && $plugin["active"]) {
                $this->context->getDispatcher()->subscribeObject(new $plugin["class"]());
            }
        }
    }

    private function registerServices(array $services) {
        $this->context->getDependenciesManager()->addServices($services);
    }

    private function registerTemplatingExtensions($dir, array $templating_extensions) {

        foreach ($templating_extensions as $extensionDir) {
            $this->context->getTemplating()->addExtensionsPath($dir . DS . $extensionDir);
        }
    }

    private function includeLibraries($dir, array $libraries) {
        foreach ($libraries as $library) {
            require_once $dir . DS . $library;
        }
    }

    private function getExtensionsConfiguration($extDir) {
        $cacheFile = Loader::toSinglePath("ext::cache::extensions::" . str_replace("::", ".", $extDir) . ".config.cache", ".php");
        $extensions = array();
        $enviroment = $this->context->getConfig()->get("enviroment");

        if ($enviroment != "dev" && is_file($cacheFile)) {
            $extensions = include $cacheFile;
        } else {
            $extensionsDir = new DirectoryHelper(new RecursiveDirectoryIterator(Loader::toSinglePath($extDir, "")));
            $files = $extensionsDir->listDirectories(1);

            foreach ($files as $file) {
                if (is_file($file . DS . "manifest.yml")) {
                    $extensions[$file] = Yaml::parse($file . DS . "manifest.yml");
                }
            }

            if ($enviroment != "dev") {
                if (!Loader::isDir("ext::cache::extensions::")) {
                    mkdir(Loader::toSinglePath("ext::cache::extensions::", ""));
                }
                file_put_contents($cacheFile, '<?php return unserialize(' . var_export(serialize($extensions), true) . ');');
            }
        }

        return $extensions;
    }

}

?>