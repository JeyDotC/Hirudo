<?php

use Hirudo\Core\Events\BeforeTaskEventListener;
use Hirudo\Core\Events\BeforeTaskEvent;
use Hirudo\Core\Context\ModulesContext;

/**
 * Description of ModuleEnhablePlugin
 *
 * @author JeyDotC
 */
class ModuleEnhablePlugin extends BeforeTaskEventListener {

    protected function beforeTask(BeforeTaskEvent $e) {
        $moduleName = $e->getCall()->getModule();

        $modulesConfig = ModulesContext::instance()->getConfig()->get("Modules", array());

        if (array_key_exists($moduleName, $modulesConfig)) {
            $moduleConfig = $modulesConfig[$moduleName];
            if (array_key_exists("disabled", $moduleConfig)) {
                $e->replaceCall($moduleConfig["action"]);
                $e->stopPropagation();
            }
        }
    }

}

?>
