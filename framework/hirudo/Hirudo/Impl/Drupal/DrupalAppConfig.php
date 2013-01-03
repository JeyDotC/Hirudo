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
 *  Hirudo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 * 
 *  You should have received a copy of the GNU General Public License
 *  along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Impl\Drupal;

use Hirudo\Core\Context\AppConfig as AppConfig;
use Hirudo\Core\Annotations\Export;

require_once "DrupalHelper.php";

/**
 * Description of JAppConfig
 *
 * @author JeyDotC
 * 
 * @Export (id="config", factory="instance")
 * 
 */
class DrupalAppConfig extends AppConfig {

    private $values = array();

    /**
     *
     * @var DrupalAppConfig
     */
    private static $instance;

    /**
     *
     * @return DrupalAppConfig
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new DrupalAppConfig();
        }

        return self::$instance;
    }

    protected function load() {
    }

    public function get($key, $default = null) {
    }

    public function has($key) {
        
    }

    public function loadApp($appName) {
        
    }

    public function loadValues(array $values) {
        
    }

}

?>
