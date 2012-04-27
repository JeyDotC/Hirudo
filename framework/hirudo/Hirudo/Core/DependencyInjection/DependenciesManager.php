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
}

?>
