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

namespace Hirudo\Core\Context;

/**
 * This class brings support for configuration
 * based on the host CMS 
 *
 * @author JeyDotC
 */
abstract class AppConfig {

    function __construct() {
        $this->load();
    }

    protected abstract function load();

    public abstract function get($key, $default = null);

    public final function __set($name, $value) {
        throw new Exception("The config is a read only object.");
    }

    public final function __get($name) {
        return $this->get($name);
    }

}

?>
