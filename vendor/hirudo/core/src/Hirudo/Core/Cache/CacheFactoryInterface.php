<?php

namespace Hirudo\Core\Cache;

/**
 *
 * @author JeyDotC
 */
interface CacheFactoryInterface {
    
    /**
     * 
     * @param mixed $configuration
     */
    function setConfiguration($configuration);
    
    /**
     * 
     * @param mixed $salt
     * 
     * @return Doctrine\Common\Cache\Cache 
     */
     function createCacheInstance($salt);
}

?>
