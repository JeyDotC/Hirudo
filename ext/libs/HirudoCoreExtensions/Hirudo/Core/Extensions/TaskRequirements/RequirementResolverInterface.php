<?php

namespace Hirudo\Core\Extensions\TaskRequirements;

/**
 * Interface for all requirement resolvers. 
 * 
 * A resolver is a class that resolves parameters values based on the information
 * available about the parameter and the given source.
 *
 * @author JeyDotC
 */
interface RequirementResolverInterface {

    /**
     * Tells if this resolver recognizes this source.
     * 
     * @param mixed $source The source from which this resolver should look for
     * the requested value.
     * 
     * @return boolean True if this resolver can find the requested parameter from
     * this source.
     */
    function suports($source);

    /**
     * Returns the requested value based on the parameter and the source.
     * 
     * @param \ReflectionParameter $param The parameter for which this value will be assigned.
     * @param mixed $source The source from which the value will be taken.
     * 
     * @return mixed The resolved value.
     */
    function resolve(\ReflectionParameter $param, $source);
}

?>
