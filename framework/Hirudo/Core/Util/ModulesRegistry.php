<?php

namespace Hirudo\Core\Util;

use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Module;

/**
 * Description of ModulesRegistry
 *
 * @author JeyDotC
 */
class ModulesRegistry {

    /**
     * Small optimization for enviroments where is highly probable to call
     * various tasks in the same module.
     * 
     * @var array<Module>
     */
    private static $loadedModules = array();

    public static function moduleIsLoaded($className) {
        return isset(self::$loadedModules[$className]);
    }

    public static function loadModule($className, $loadIfNotExists = false) {
        if ($loadIfNotExists && !self::moduleIsLoaded($className)) {
            $module = Module::createModuleFromClassName($className);
            ModulesContext::instance()->getDependenciesManager()->resolveDependencies($module);
            self::$loadedModules[$className] = $module;
        }
        return isset(self::$loadedModules[$className]) ? self::$loadedModules[$className] : null;
    }

}

?>
