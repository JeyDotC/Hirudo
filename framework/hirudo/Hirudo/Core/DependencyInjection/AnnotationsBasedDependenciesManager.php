<?php

/**
 * «Copyright 2012 Jeysson José Guevara Mendivil(JeyDotC)» 
 * 
 * This file is part of Hirudo.
 * 
 * Hirudo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 *  Hirudo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 * 
 *  You should have received a copy of the GNU General Public License
 *  along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Core\DependencyInjection;

use Doctrine\Common\Annotations\AnnotationReader;
use Hirudo\Lang\Loader as Loader;
use Hirudo\Core\Annotations\Import;
use Hirudo\Core\Annotations\Export;
use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\ContainerAware;

//A quick fix for a weird issue with the autoloader when dealing with annotations.
Loader::using("framework::hirudo::Hirudo::Core::Annotations::*");

/**
 * A dependencies manager that uses the doctrine's doc-block annotations system
 * to determine dependencies and load services.
 * 
 * @author JeyDotC
 * @todo The annotations reader can't autoload annotations for some reason.
 */
class AnnotationsBasedDependenciesManager extends ContainerAware implements DependenciesManager {

    /**
     *
     * @var AnnotationReader
     */
    private $annotationReader;

    function __construct() {
        $this->setContainer(new ContainerBuilder());
        $this->annotationReader = new AnnotationReader();
    }

    /**
     * This method takes an array of fully qualified class names and registers them
     * in the container to inject them later. Such classes must be annotated with
     * the @Export annotation in order to be injected. 
     * 
     * @param array $implementationClasses An array of fully qualified class names.
     * 
     * @see Export the @Export annotation for more information about exporting classes.
     */
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

    /**
     * Resolves all dependencies in the given object. A dependency is announced
     * by using the @Import annotation on a public setter method or a property 
     * regardless it's access level.
     * 
     * @param mixed $object 
     * 
     * @see Import
     * @see Export
     */
    public function resolveDependencies($object) {
        $objectReflection = new \ReflectionClass($object);

        //Resolve property dependency injection.
        foreach ($objectReflection->getProperties() as /* @var $property \ReflectionProperty */$property) {

            $annotation = $this->annotationReader->getPropertyAnnotation($property, "Hirudo\Core\Annotations\Import");

            if ($annotation) {
                $this->resolveDependencyForProperty($object, $property, $annotation);
            }
        }

        //Resolve method dependency injection.
        foreach ($objectReflection->getMethods(\ReflectionMethod::IS_PUBLIC) as /* @var $method \ReflectionMethod */$method) {
            /* @var $annotation Import */
            $annotation = $this->annotationReader->getMethodAnnotation($method, "Hirudo\Core\Annotations\Import");
            if ($annotation) {
                $this->resolveDependencyForMethod($object, $method, $annotation);
            }
        }
    }

    private function resolveDependencyForMethod($object,
            \ReflectionMethod $method, Import $annotation) {

        $id = $annotation->id;

        if (empty($id)) {
            /* @var $parameters \ReflectionParameter */
            $parameters = $method->getParameters();
            $type = $parameters[0]->getClass();
            $id = $type->name;

            if (!$this->container->has($id)) {
                $this->container->register($id, $type->newInstance());
            }
        }

        $requestedObject = $this->container->get($id);

        $this->resolveDependencies($requestedObject);
        $method->invoke($object, $requestedObject);
    }

    private function resolveDependencyForProperty($object,
            \ReflectionProperty $property, Import $annotation) {
        $id = $annotation->id;

        if (empty($id)) {
            $type = new \ReflectionClass($annotation->className);
            $id = $type->name;

            if (!$this->container->has($id)) {
                $this->container->register($id, $type->newInstance());
            }
        }

        $requestedObject = $this->container->get($id);

        $this->resolveDependencies($requestedObject);

        $makeUnaccesible = false;

        if ($property->isPrivate() || $property->isProtected()) {
            $property->setAccessible(true);
            $makeUnaccesible = true;
        }

        $property->setValue($object, $requestedObject);

        if ($makeUnaccesible) {
            $property->setAccessible(false);
        }
    }

    /**
     * Gets the annotations associated to thie given class.
     * 
     * @param \ReflectionClass $object
     * @return array<mixed> 
     */
    public function getClassMetadata(\ReflectionClass $object) {
        return $this->annotationReader->getClassAnnotations($object);
    }

    /**
     * Gets the annotations associated to thie given method.
     * 
     * @param \ReflectionMethod $method
     * @return array<mixed> 
     */
    public function getMethodMetadata(\ReflectionMethod $method) {
        return $this->annotationReader->getMethodAnnotations($method);
    }

    /**
     * Gets the annotations associated to thie given property.
     * 
     * @param \ReflectionProperty $property
     * @return array<mixed> 
     */
    public function getPropertyMetadata(\ReflectionProperty $property) {
        return $this->annotationReader->getPropertyAnnotations($property);
    }

    /**
     * Gets an annotation associated to thie given class by it's fully qualified class name.
     * 
     * @param \ReflectionClass $object
     * @param string $metaDataId The annotation's fully qualified class name
     * @return mixed The annotation, or null if it doesn't exists for this class.
     */
    public function getClassMetadataById(\ReflectionClass $object, $metaDataId) {
        return $this->annotationReader->getClassAnnotation($object, $metaDataId);
    }

    /**
     * Gets an annotation associated to thie given method by it's fully qualified class name.
     * 
     * @param \ReflectionMethod $method
     * @param string $metaDataId The annotation's fully qualified class name
     * @return mixed The annotation, or null if it doesn't exists for this method.
     */
    public function getMethodMetadataById(\ReflectionMethod $method, $metaDataId) {
        return $this->annotationReader->getMethodAnnotation($method, $metaDataId);
    }

    /**
     * Gets an annotation associated to thie given property by it's fully qualified class name.
     * 
     * @param \ReflectionProperty $property
     * @param string $metaDataId The annotation's fully qualified class name
     * @return mixed The annotation, or null if it doesn't exists for this property.
     */
    public function getPropertyMetadataById(\ReflectionProperty $property,
            $metaDataId) {
        return $this->annotationReader->getPropertyAnnotation($property, $metaDataId);
    }

}

?>
