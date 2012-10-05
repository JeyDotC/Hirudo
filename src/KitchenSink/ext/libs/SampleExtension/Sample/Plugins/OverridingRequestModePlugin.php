<?php

namespace Sample\Plugins;

use Hirudo\Core\Annotations\HttpMethod;
use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Events\Annotations\Listen;
use Hirudo\Core\Events\BeforeTaskEvent;

/**
 * Description of FixtureTaskRequirementsPlugin
 *
 * @author JeyDotC
 */
class OverridingRequestModePlugin {

    /**
     *
     * @var ModulesContext 
     */
    private $context;

    function __construct() {
        $this->context = ModulesContext::instance();
    }

    /**
     * This method tries to resolve the task requirements by checking its parameters
     * and looking for the corresponding values in the request variables.
     * 
     * @param BeforeTaskEvent $e
     * 
     * @Listen(to="beforeTask", overrides="check_request_mode")
     */
    function checkRequestMode(BeforeTaskEvent $e) {
        $annotation = $e->getTask()->getTaskAnnotation("Hirudo\Core\Annotations\HttpMethod");
        $currentMethod = $this->context->getRequest()->method();

        if ($annotation instanceof HttpMethod && !in_array(strtoupper($currentMethod), $annotation->value)) {
            $this->context->getRouting()->redirect("http://www.google.com?q=$currentMethod");
        }
    }

}

?>
