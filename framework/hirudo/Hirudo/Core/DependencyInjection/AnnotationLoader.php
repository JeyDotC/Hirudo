<?php

namespace Hirudo\Core\DependencyInjection;

use Doctrine\Common\Annotations\AnnotationReader;
use Hirudo\Core\Annotations\Export as Export;
use Hirudo\Core\Annotations\Import as Import;
use Hirudo\Libs\Lang\Loader as Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder as ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Description of AnnotationLoader
 *
 * @author JeyDotC
 */
class AnnotationLoader extends ContainerAware {

    private $annotationReader;

    function __construct() {
        $this->setContainer(new \ContainerBuilder());
        $this->annotationReader = new AnnotationReader();
    }

    public function addServices(array $implementationClasses) {
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

    public function resolveDependencies($object) {
        $contextReflection = new \ReflectionClass($object);

        foreach ($contextReflection->getMethods(\ReflectionMethod::IS_PUBLIC) as /* @var $method \ReflectionMethod */$method) {
            /* @var $annotation \Import */
            $annotation = $this->annotationReader->getMethodAnnotation($method, "Hirudo\Core\Annotations\Import");
            if ($annotation) {
                $method->invoke($object, $this->container->get($annotation->id));
            }
        }
    }

}

?>
