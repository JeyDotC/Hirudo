<?php

namespace Hirudo\Core\Extensions\Plugins;

use Exception;
use Hirudo\Core\Annotations\HttpMethod;
use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Events\Annotations\Listen;
use Hirudo\Core\Events\Annotations\VirtualListener;
use Hirudo\Core\Events\BeforeTaskEvent;

/**
 * This plugin ensures that a task can only be called when the current HTTP
 * method matches any of the HTTP methods accepted by the task.
 *
 * @author JeyDotC
 */
class RequestModePlugin {
    
    private $context;

    function __construct() {
        $this->context = ModulesContext::instance();
    }
    
    /**
     * This method ensures that a task gets called only on the request methods
     * it accepts based on its annotations.
     * 
     * @param BeforeTaskEvent $e
     * 
     * @throws Exception When the current HTTP method doesn't match any of the
     * task's accepted HTTP methods
     * 
     * @Listen(to="beforeTask", priority=9)
     * @VirtualListener(id="check_request_mode")
     */
    function checkRequestMode(BeforeTaskEvent $e) {
        $annotation = $e->getTask()->getTaskAnnotation("Hirudo\Core\Annotations\HttpMethod");
        $currentMethod = $this->context->getRequest()->method();
        if($annotation instanceof HttpMethod &&  !in_array(strtoupper($currentMethod), $annotation->value)){
            $accectedMethods = implode(" or ", $annotation->value);
            throw new \Exception("The task [{$this->context->getCurrentCall()}] accepts $accectedMethods requests only, received $currentMethod");
        }
    }
}

?>
