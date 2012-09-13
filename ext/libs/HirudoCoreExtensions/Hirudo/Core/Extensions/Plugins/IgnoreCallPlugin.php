<?php

namespace Hirudo\Core\Extensions\Plugins;

use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Context\ModuleCall;
use Hirudo\Core\Events\Annotations\Listen;
use Hirudo\Core\Events\BeforeTaskEvent;

/**
 * This plugin checks if the task to be executed is annotated with the 
 * Hirudo\Core\Annotations\IgnoreCall annotation. If so, it redirects to the 
 * onModuleNotFound page.
 *
 * @author JeyDotC
 */
class IgnoreCallPlugin {

    private $context;
    
    /**
     * Creates a new IgnoreCallPlugin
     */
    function __construct() {
        $this->context = ModulesContext::instance();
    }

    /**
     * Listens to the <code>beforeTask</code> event to check if the task is
     * annotated with the Hirudo\Core\Annotations\IgnoreCall annotation.
     * 
     * The listener has a high priority to prevent the unnecesary execution of
     * further event listeners.
     * 
     * @param BeforeTaskEvent $e 
     * 
     * @Listen(to="beforeTask", priority=10)
     */
    function checkIgnoreCall(BeforeTaskEvent $e) {
        $result = $e->getTask()->getTaskAnnotation("Hirudo\Core\Annotations\IgnoreCall");
        if (!is_null($result)) {
            $e->replaceCall($this->getModuleNotFoundCall());
            $e->stopPropagation();
        }
    }

    /**
     * Gets the <code>onModuleNotFound</code> call from configuration.
     * 
     * @return ModuleCall
     */
    private function getModuleNotFoundCall() {
        return ModuleCall::fromString($this->context->getConfig()->get("onModuleNotFound"));
    }

}

?>
