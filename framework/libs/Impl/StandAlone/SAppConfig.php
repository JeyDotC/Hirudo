<?php

namespace Hirudo\Libs\Impl\StandAlone;

use Hirudo\Core\Context\AppConfig as AppConfig;
use Hirudo\Core\Annotations\Export as Export;

/**
 * Description of SAppConfig 
 *
 * @author JeyDotC
 * 
 * @Export(id="Config")
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
        $json = file_get_contents(Loader::toSinglePath("config", ".json"));
        $this->document = JSON::Decode($json, true);
    }

}

?>
