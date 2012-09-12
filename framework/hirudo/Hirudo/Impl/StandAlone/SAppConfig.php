<?php

/**
 * «Copyright 2012 Jeysson José Guevara Mendivil(JeyDotC)» 
 * 
 * This file is part of Hirudo.
 * 
 * Hirudo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Hirudo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Impl\StandAlone;

use Hirudo\Core\Context\AppConfig as AppConfig;
use Hirudo\Lang\Loader;
use Symfony\Component\Yaml\Yaml;

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
    private $document = array();

    public function get($key, $default = null) {
        $result = $default;
        if ($this->has($key)) {
            $result = $this->document[$key];
        }
        return $result;
    }

    protected function load() {
        $file = Loader::toSinglePath("ext::config::Config", ".yml");
        $this->loadYMLFiles(array($file));
    }

    public function has($key) {
        return isset($this->document[$key]);
    }

    public function loadApp($appName) {
        $businesRoot = $this->get("businessRoot", "src");
        $files = Loader::toPaths("$businesRoot::$appName::ext::config::*", ".yml");
        $this->loadYMLFiles($files);
    }

    private function loadYMLFiles(array $files) {
        foreach ($files as $file) {
            if (file_exists($file)) {
                $this->document = array_merge($this->document, Yaml::parse($file));
            }
        }
    }

}

?>
