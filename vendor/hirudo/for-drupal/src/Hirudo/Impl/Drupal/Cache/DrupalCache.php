<?php

namespace Hirudo\Impl\Drupal\Cache;

use Doctrine\Common\Cache\CacheProvider;

/**
 * This class is experimental!
 *
 * @author JeyDotC
 */
class DrupalCache extends CacheProvider {

    protected function doContains($id) {
        return (boolean) cache_get($id);
    }

    protected function doDelete($id) {
        cache_clear_all($id);
        return true;
    }

    protected function doFetch($id) {
        return unserialize(cache_get($id));
    }

    protected function doFlush() {
        cache_clear_all();
    }

    protected function doGetStats() {
        return null;
    }

    protected function doSave($id, $data, $lifeTime = false) {
        cache_set($id, serialize($data), "cache", (int) $lifeTime);
        return true;
    }

}

?>
