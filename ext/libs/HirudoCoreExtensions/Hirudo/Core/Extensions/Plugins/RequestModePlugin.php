<?php

namespace Hirudo\Core\Extensions\Plugins;

use Exception;
use Hirudo\Core\Annotations\HttpMethod;
use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Events\Annotations\Listen;
use Hirudo\Core\Events\BeforeTaskEvent;

/**
 * Description of RequestModePlugin
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
     * @throws Exception When the method is annotated with the Hirudo\Core\Annotations\HttpPost
     * annotation and the method is tried to be accesed via GET.
     * 
     * @Listen(to="beforeTask", priority=9, virtual=true, id="check_request_mode")
     */
    function checkRequestMode(BeforeTaskEvent $e) {
        $annotation = $e->getTask()->getTaskAnnotation("Hirudo\Core\Annotations\HttpMethod");
        $currentMethod = $this->context->getRequest()->method();
        $accectedMethods = implode(", ", $annotation->value);
        if($annotation instanceof HttpMethod &&  !in_array(strtoupper($currentMethod), $annotation->value)){
            $accectedMethods = implode(" or ", $annotation->value);
            throw new \Exception("The task [{$this->context->getCurrentCall()}] accepts $accectedMethods requests only, received $currentMethod");
        }
    }
}

?>
