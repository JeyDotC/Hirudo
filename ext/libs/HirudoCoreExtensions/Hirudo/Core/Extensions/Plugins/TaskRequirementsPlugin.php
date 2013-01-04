<?php

namespace Hirudo\Core\Extensions\Plugins;

use Hirudo\Core\Annotations\Import;
use Hirudo\Core\Annotations\Resolve;
use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Events\Annotations\Listen;
use Hirudo\Core\Events\Annotations\VirtualListener;
use Hirudo\Core\Events\BeforeTaskEvent;
use Hirudo\Core\Extensions\TaskRequirements\RequestRequirementResolver;
use Hirudo\Core\Extensions\TaskRequirements\RequirementResolverInterface;
use ReflectionParameter;
use Symfony\Component\EventDispatcher\Event;

/**
 * Tries to resolve the tasks requirements taking data from POST and/or GET 
 * based on the task's parameters.
 *
 * @author JeyDotC
 */
class TaskRequirementsPlugin {

    private $context;
    private $resolvers = array();

    function __construct() {
        $this->context = ModulesContext::instance();
        //The default resolver
        $this->resolvers["default_resolver"] = new RequestRequirementResolver();
    }

    /**
     * 
     * @param RequirementResolverInterface $resolver
     * @Import(tag="requirements_resolver")
     */
    public function addResolver(RequirementResolverInterface $resolver) {
        $this->resolvers[get_class($resolver)] = $resolver;
    }

    /**
     * 
     * @param \Symfony\Component\EventDispatcher\Event $e
     * @Listen(to="applicationLoaded")
     */
    function onApplicationLoaded(Event $e) {
        $this->context->getDependenciesManager()->resolveDependencies($this);
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

        /* @var $resolve Resolve */
        $resolve = $task->getTaskAnnotation("Hirudo\Core\Annotations\Resolve");
        $isPostOnly = $task->getTaskAnnotation("Hirudo\Core\Annotations\HttpPost") != null;

        foreach ($task->getParams() as /* @var $param ReflectionParameter */ $param) {
            if ($resolve == null || !array_key_exists($param->name, $resolve->value)) {
                $source = "";
                if (!$param->isArray() && is_null($param->getClass()) && !$isPostOnly) {
                    $source = "get";
                } else {
                    $source = "post";
                }
                $task->setParamValue($param->name, $this->resolvers["default_resolver"]->resolve($param, $source));
            } else {
                foreach ($this->resolvers as $resolver) {
                    $source = $resolve->value[$param->name];
                    if ($resolver->suports($resolve->value[$param->name])) {
                        $task->setParamValue($param->name, $resolver->resolve($param, $source));
                    }
                }
            }
        }
    }

}

?>
