<?php

namespace Hirudo\Core\Extensions\Plugins;

use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Events\Annotations\Listen;
use Hirudo\Core\Events\Annotations\VirtualListener;
use Hirudo\Core\Events\BeforeTaskEvent;

/**
 * Tries to resolve the tasks requirements taking data from POST and/or GET 
 * based on the task's parameters.
 *
 * @author JeyDotC
 */
class TaskRequirementsPlugin {

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
     * @Listen(to="beforeTask", priority=8)
     * @VirtualListener(id="task_requirements_resolver")
     */
    function resolveTaskRequirements(BeforeTaskEvent $e) {
        $task = $e->getTask();

        $isPostOnly = $task->getTaskAnnotation("Hirudo\Core\Annotations\HttpPost") != null;

        foreach ($task->getParams() as /* @var $param \ReflectionParameter */ $param) {
            $defaultValue = $task->getParamValue($param->name);
            if (!$param->isArray() && is_null($param->getClass()) && !$isPostOnly) {
                $task->setParamValue($param->name, $this->context->getRequest()->get($param->name, $defaultValue));
            } else {
                if ($param->getClass() != null) {
                    $object = $param->getClass()->newInstance();
                    $this->context->getRequest()->bind($object, $this->context->getRequest()->post($param->name));
                    $task->setParamValue($param->name, $object);
                } else {
                    $task->setParamValue($param->name, $this->context->getRequest()->post($param->name, $defaultValue));
                }
            }
        }
    }

}

?>
