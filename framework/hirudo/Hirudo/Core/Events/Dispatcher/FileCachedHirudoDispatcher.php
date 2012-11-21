<?php

namespace Hirudo\Core\Events\Dispatcher;

use Hirudo\Core\Events\Dispatcher\HirudoDispatcher;

/**
 * Description of FileCachedHirudoDispatcher
 *
 * @author JeyDotC
 */
class FileCachedHirudoDispatcher extends HirudoDispatcher {

    private $dir;
    private $debug;
    private $loadedObjects = array();

    public function __construct($cacheDir, $debug = false) {
        if (!is_dir($cacheDir) && !@mkdir($cacheDir, 0777, true)) {
            throw new \InvalidArgumentException(sprintf('The directory "%s" does not exist and could not be created.', $cacheDir));
        }
        if (!is_writable($cacheDir)) {
            throw new \InvalidArgumentException(sprintf('The directory "%s" is not writable. Both, the webserver and the console user need access. You can manage access rights for multiple users with "chmod +a". If your system does not support this, check out the acl package.', $cacheDir));
        }

        $this->dir = rtrim($cacheDir, '\\/');
        $this->debug = $debug;
    }

    protected function loadObjectListeners(\ReflectionClass $reflectedObject, $object) {
        $key = $reflectedObject->getName();
        if (isset($this->loadedObjects[$key])) {
            return $this->loadedObjects[$key];
        }

        $path = $this->dir . '/' . strtr($key, '\\', '-') . '.cache.php';

        if (!file_exists($path)) {
            $listeners = parent::loadObjectListeners($reflectedObject, $object);
            $this->saveCacheFile($path, $listeners);
            return $this->loadedObjects[$key] = $listeners;
        }

        if ($this->debug
                && (false !== $filename = $reflectedObject->getFilename())
                && filemtime($path) < filemtime($filename)) {
            @unlink($path);

            $listeners = parent::loadObjectListeners($reflectedObject, $object);
            $this->saveCacheFile($path, $listeners);
            return $this->loadedObjects[$key] = $listeners;
        }

        return $this->loadedObjects[$key] = include $path;
    }

    private function saveCacheFile($path, $data) {
        file_put_contents($path, '<?php return unserialize(' . var_export(serialize($data), true) . ');');
    }

}

?>
