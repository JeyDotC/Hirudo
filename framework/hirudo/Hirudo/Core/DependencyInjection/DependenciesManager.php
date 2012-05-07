<?php

namespace Hirudo\Core\DependencyInjection;

/**
 *
 * @author JeyDotC
 */
interface DependenciesManager {

    /**
     * This method takes an array of fully qualified class names and registers them
     * in the container to inject them later.
     * 
     * @param array $implementationClasses An array of fully qualified class names.
     */
    function addServices(array $implementationClasses);

    /**
     * Resolves all dependencies in the given object.
     * 
     * @param mixed $object 
     */
    function resolveDependencies($object);

    /**
     * Gets the metadata associated to the given object.
     * 
     * @param \ReflectionClass $object
     * 
     * @return array<mixed> The metadata values, normally objects with plain information about the class. 
     */
    function getClassMetadata(\ReflectionClass $object);

    /**
     * Gets the metadata associated to the given method.
     * 
     * @param \ReflectionMethod $method
     * 
     * @return array<mixed> The metadata values, normally objects with plain information about the method. 
     */
    function getMethodMetadata(\ReflectionMethod $method);
    
    /**
     * Gets the metadata associated to the given property.
     * 
     * @param \ReflectionProperty $property
     * 
     * @return array<mixed> The metadata values, normally objects with plain information about the property. 
     */
    function getPropertyMetadata(\ReflectionProperty $property);
}

?>
