<?php

namespace Hirudo\Core\Cache;

use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Cache\PhpFileCache;
use Doctrine\Common\Cache\WinCacheCache;
use Doctrine\Common\Cache\XcacheCache;
use Doctrine\Common\Cache\ZendDataCache;
use Exception;
use Hirudo\Lang\Loader;

/**
 * Description of DefaultCacheFactory
 *
 * @author JeyDotC
 */
class DefaultCacheFactory implements CacheFactoryInterface {

    private $config = array(
        "type" => "array",
    );

    public function createCacheInstance($salt) {

        $method = "_{$this->config["type"]}";
        if (!method_exists($this, $method)) {
            throw new Exception("Cache type '{$this->config["type"]}' not supported.");
        }
        return $this->{$method}($salt);
    }

    public function setConfiguration($configuration) {
        $this->config = array_merge($this->config, $configuration);
    }

    protected function _filesystem($salt) {
        $instance = new FilesystemCache($this->getFolder($this->config["cache_folder"], $salt));
        return $instance;
    }

    protected function _apc() {
        return new ApcCache();
    }

    protected function _array() {
        return new ArrayCache();
    }

    protected function _phpfile($salt) {
        $instance = new PhpFileCache(($this->getFolder($this->config["cache_folder"], $salt)));
        return $instance;
    }

    protected function _zenddata() {
        return new ZendDataCache();
    }

    protected function _xcache() {
        return new XcacheCache();
    }

    protected function _wincache() {
        return new WinCacheCache();
    }

    private function getFolder($folderAlias, $salt) {
        return Loader::toSinglePath($folderAlias, DS) . $salt;
    }

}

?>
