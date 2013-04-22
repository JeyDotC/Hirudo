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
use Symfony\Component\EventDispatcher\Event;

/**
 * Tries to resolve the task's requirements taking data from the known
 * resolvers.
 *
 * The resolvers are those classes that implement the 
 * {@link Hirudo\Core\Extensions\TaskRequirements\RequirementResolverInterface}
 * interface and are registered as services under the tag 
 * <code>requirements_resolver</code> using the Hirudo\Core\Annotations\Export
 * annotation.
 * 
 * @author JeyDotC
 */
class TaskRequirementsPlugin {

    private $context;
    private $resolvers = array();

    /**
     * Constructs a new TaskRequirementsPlugin with a default resolver.
     * 
     * @see Hirudo\Core\Extensions\TaskRequirements\RequestRequirementResolver
     */
    function __construct() {
        $this->context = ModulesContext::instance();
        $this->resolvers["default_resolver"] = new RequestRequirementResolver();
    }

    /**
     * This method gathers all the available resolvers.
     * 
     * @param RequirementResolverInterface $resolver
     * @Import(tag="requirements_resolver")
     */
    public function addResolver(RequirementResolverInterface $resolver) {
        $this->resolvers[get_class($resolver)] = $resolver;
    }

    /**
     * Look for application-local resolvers.
     * 
     * @param Event $e
     * @Listen(to="applicationLoaded")
     */
    function onApplicationLoaded(Event $e) {
        $this->context->getDependenciesManager()->resolveDependencies($this);
    }

    /**
     * Attempts to resolve the task's requirements delegating the job to the 
     * known resolvers.
     * 
     * @param BeforeTaskEvent $e
     * 
     * @Listen(to="beforeTask", priority=8)
     * @VirtualListener(id="task_requirements_resolver")
     */
    function resolveTaskRequirements(BeforeTaskEvent $e) {
        $task = $e->getTask();

        /* @var $resolve Resolve */
        $resolve = $task->getTaskAnnotation("Hirudo\Core\Extensions\TaskRequirements\Annotations\Resolve");
        $isPostOnly = $task->getTaskAnnotation("Hirudo\Core\Annotations\HttpPost") != null;

        foreach ($task->getParams() as /* @var $param ReflectionParameter */ $param) {
            if ($resolve == null || (!array_key_exists($param->name, $resolve->value) && !array_key_exists("__all", $resolve->value))) {
                $source = "";
                if (!$param->isArray() && is_null($param->getClass()) && !$isPostOnly) {
                    $source = "get";
                } else {
                    $source = "post";
                }
                $task->setParamValue($param->name, $this->resolvers["default_resolver"]->resolve($param, $source));
            } else {
                foreach ($this->resolvers as $resolver) {
                    $source = array_key_exists($param->name, $resolve->value) ? $resolve->value[$param->name] : $resolve->value["__all"];
                    if ($resolver->suports($source)) {
                        $task->setParamValue($param->name, $resolver->resolve($param, $source));
                    }
                }
            }
        }
    }

}

?>
