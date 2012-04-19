<?php

namespace Hirudo\Impl\StandAlone;

use Hirudo\Core\Context\AppConfig as AppConfig;
use Hirudo\Lang\Loader;

/**
 * Description of SAppConfig 
 *
 * @author JeyDotC
 * 
 * @Hirudo\Core\Annotations\Export(id="Config")
 * 
 */
class SAppConfig extends AppConfig {

    /**
     *
     * @var array
     */
    private $document;

    public function get($key, $default = null) {
        $result = $default;
        if (isset($this->document[$key])) {
            $result = $this->document[$key];
        }
        return $result;
    }

    protected function load() {
        $path = Loader::toSinglePath("ext::config::config", ".json");
        $json = "{}";
        if (file_exists($path)) {
            $json = file_get_contents($path);
        }
        $this->document = JSON::Decode($json, true);
    }

}

?>
