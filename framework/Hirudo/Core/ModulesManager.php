<?php

namespace Hirudo\Core;

use Doctrine\Common\Annotations\AnnotationReader;
use Hirudo\Core\Annotations\Export as Export;
use Hirudo\Core\Annotations\Import as Import;
use Hirudo\Libs\Lang\Loader as Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder as ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Description of ModulesManager
 *
 * @author JeyDotC
 */
class ModulesManager extends ContainerAware {

    private $annotationReader;

    function __construct(array $implementationClasses) {
        $this->setContainer(new \ContainerBuilder());
        $this->annotationReader = new AnnotationReader();

        foreach ($implementationClasses as $class => $path) {
            Loader::using($path);
            /* @var $annotation Export */
            $annotation = $this->annotationReader->getClassAnnotation(new ReflectionClass($class), "Hirudo\Core\Annotations\Export");
            $definition = $this->container->register($annotation->id, $class);
            if (!empty($annotation->factory)) {
                $definition->setFactoryClass($class)->setFactoryMethod($annotation->factory);
            }
        }
    }

}

?>
