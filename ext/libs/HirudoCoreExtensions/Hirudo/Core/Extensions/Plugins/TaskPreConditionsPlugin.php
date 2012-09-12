<?php

namespace Hirudo\Core\Extensions\Plugins;

use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Context\ModuleCall;
use Hirudo\Core\Events\Annotations\Listen;
use Hirudo\Core\Events\BeforeTaskEvent;

/**
 * Description of TaskExecutionCheckout
 *
 * @author JeyDotC
 */
class TaskPreConditionsPlugin {

    private $context;

    function __construct() {
        $this->context = ModulesContext::instance();
    }

    /**
     * 
     * @param BeforeTaskEvent $e
     * @Listen(to="beforeTask", priority=9)
     */
    function resolveTaskRequirements(BeforeTaskEvent $e) {
        $task = $e->getTask();

        if ($task->isPostOnly() && $this->context->getRequest()->method() != "POST") {
            throw new \Exception("The task [{$this->context->getCurrentCall()}] accepts POST requests only");
        }

        foreach ($task->getGetParams() as /* @var $param \ReflectionParameter */ $param) {
            $task->setParamValue($param->name, $this->context->getRequest()->get($param->name, $task->getParamValue($param->name)));
        }

        foreach ($task->getPostParams() as /* @var $param ReflectionParameter */ $param) {
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
     * @param BeforeTaskEvent $e
     * @Listen(to="beforeTask", priority=10)
     */
    function checkIgnoreCall(BeforeTaskEvent $e) {
        $result = $e->getTask()->getTaskAnnotation("Hirudo\Core\Annotations\IgnoreCall");
        if (!is_null($result)) {
            $e->replaceCall($this->getModuleNotFoundCall());
            $e->stopPropagation();
        }
    }
    
    function checkRoles(BeforeTaskEvent $e) {
        
    }

    private function getModuleNotFoundCall() {
        return ModuleCall::fromString($this->context->getConfig()->get("onModuleNotFound"));
    }

}

?>
