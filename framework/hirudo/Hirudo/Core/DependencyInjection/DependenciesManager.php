<?php

namespace Hirudo\Core\DependencyInjection;

/**
 * This is the interface for all dependency injection managers.
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
    
    /**
     * Gets a single metadata object by id from
     * a class.
     * 
     * @param \ReflectionClass $object
     * @param string $metadataId The metadata id (usually an annotation class name)
     * 
     * @return mixed The metadata value, normally an object with plain information about the class.
     */
    function getClassMetadataById(\ReflectionClass $object, $metaDataId);

    /**
     * Gets a single metadata object by id from
     * a method.
     * 
     * @param \ReflectionMethod $method
     * @param string $metadataId The metadata id (usually an annotation class name)
     * 
     * @return mixed The metadata value, normally an object with plain information about the method.
     */
    function getMethodMetadataById(\ReflectionMethod $method, $metaDataId);

    /**
     * Gets a single metadata object by its id from
     * a property.
     * 
     * @param \ReflectionProperty $property
     * @param string $metadataId The metadata id (usually an annotation class name)
     * 
     * @return mixed The metadata value, normally an object with plain information about the property.
     */
    function getPropertyMetadataById(\ReflectionProperty $property, $metaDataId);
}

?>
