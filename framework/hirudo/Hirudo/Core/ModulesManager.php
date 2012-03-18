<?php

namespace Hirudo\Core;

use Hirudo\Core\DependencyInjection\AnnotationLoader;

/**
 * Description of ModulesManager
 *
 * @author JeyDotC
 */
class ModulesManager extends ContainerAware {

    /**
     *
     * @var AnnotationLoader
     */
    private $dependencyManager;

    function __construct(array $implementationClasses) {
        $this->dependencyManager = new AnnotationLoader();
        $this->dependencyManager->addServices($implementationClasses);
        $this->load();
    }

    private function load() {
        $this->dependencyManager->resolveDependencies(Context\ModulesContext::instance());
    }

}

?>
