<?php

namespace Hirudo\Core\Events\Dispatcher;

use Doctrine\Common\Cache\Cache;

/**
 * Description of CachedHirudoDispatcher
 *
 * @author JeyDotC
 */
class CachedHirudoDispatcher extends HirudoDispatcher {

    const CACHE_SALT = "@[Hirudo.Dispatcher]";

    /**
     *
     * @var HirudoDispatcher
     */
    private $delegate;

    /**
     *
     * @var Cache
     */
    private $cache;
    private $loadedObjects = array();

    function __construct(HirudoDispatcher $delegate, Cache $cache) {
        $this->delegate = $delegate;
        $this->cache = $cache;
    }

    protected function loadObjectListeners(\ReflectionClass $reflectedObject, $object) {
        $key = $reflectedObject->getName()  . self::CACHE_SALT;
        if (isset($this->loadedObjects[$key])) {
            return $this->loadedObjects[$key];
        }
        
        $loadedObjects = $this->cache->fetch($key);
        if ($loadedObjects === false) {
            $loadedObjects = $this->delegate->loadObjectListeners($reflectedObject, $object);
            $this->cache->save($key, $loadedObjects);
        }

        return $this->loadedObjects[$key] = $loadedObjects;
    }

}

?>
