<?php

namespace Hirudo\Core\DependencyInjection;

use Doctrine\Common\Annotations\AnnotationReader;
use Hirudo\Lang\Loader as Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\ContainerAware;

//A quick fix for a weird issue with the autoloader when dealing with annotations.
Loader::using("framework::hirudo::Hirudo::Core::Annotations::Import");
Loader::using("framework::hirudo::Hirudo::Core::Annotations::Export");

/**
 * Description of AnnotationLoader
 *
 * @author JeyDotC
 */
class AnnotationLoader extends ContainerAware {

    private $annotationReader;

    function __construct() {
        $this->setContainer(new ContainerBuilder());
        $this->annotationReader = new AnnotationReader();
    }

    public function addServices(array $implementationClasses) {
        foreach ($implementationClasses as $class) {
            /* @var $annotation Export */
            $annotation = $this->annotationReader->getClassAnnotation(new \ReflectionClass($class), "Hirudo\Core\Annotations\Export");
            if ($annotation) {
                $definition = $this->container->register($annotation->id, $class);
                if (!empty($annotation->factory)) {
                    $definition->setFactoryClass($class)->setFactoryMethod($annotation->factory);
                }
            }
        }
    }

    public function resolveDependencies($object) {
        $objectReflection = new \ReflectionClass($object);

        foreach ($objectReflection->getMethods(\ReflectionMethod::IS_PUBLIC) as /* @var $method \ReflectionMethod */$method) {
            /* @var $annotation \Import */
            $annotation = $this->annotationReader->getMethodAnnotation($method, "Hirudo\Core\Annotations\Import");
            if ($annotation) {
                $requestedObject = $this->container->get($annotation->id);
                $this->resolveDependencies($requestedObject);
                $method->invoke($object, $requestedObject);
            }
        }
    }

}

?>
