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

namespace Hirudo\Impl\Joomla;

use Hirudo\Core\Context\AppConfig as AppConfig;
use Hirudo\Core\Annotations\Export;

require_once "JoomlaHelper.php";

/**
 * Description of JAppConfig
 *
 * @author JeyDotC
 * 
 * @Export (id="config", factory="instance")
 * 
 */
class JoomlaAppConfig extends AppConfig {

    /**
     *
     * @var JAppConfig
     */
    private static $instance;

    /**
     *
     * @return JAppConfig
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new JAppConfig();
        }

        return self::$instance;
    }

    /**
     *
     * @var JParameter 
     */
    private $configObject;

    public function get($key, $default = null) {
        return $this->configObject->get($key, $default);
    }

    protected function load() {
        $mainframe = JoomlaHelper::getMainframe();
        $this->configObject = $mainframe->getPageParameters($mainframe->scope);
    }

}

?>
