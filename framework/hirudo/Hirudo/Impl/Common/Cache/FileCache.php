<?php

namespace Hirudo\Impl\Common\Cache;

use Doctrine\Common\Cache\ArrayCache;

/**
 * Description of FileCache
 *
 * @author JeyDotC
 */
class FileCache extends ArrayCache {

    protected function doContains($id) {
        $contains = parent::doContains($id);
        if (!$contains) {
            $contains = is_file($id);
        }

        return $contains;
    }

    protected function doDelete($id) {
        parent::doDelete($id);
        return unlink($id);
    }

    protected function doFetch($id) {
        $fetch = parent::doFetch($id);
        if ($fetch === false) {
            $fetch = unserialize(file_get_contents($id));
        }

        return $fetch;
    }

    protected function doFlush() {
        return parent::doFlush();
    }

    protected function doGetStats() {
        return parent::doGetStats();
    }

    protected function doSave($id, $data, $lifeTime = 0) {
        $result = file_put_contents($id, serialize($data));
        
        if ($result === false) {
            return false;
        }

        return parent::doSave($id, $data, $lifeTime);
    }

}

?>
