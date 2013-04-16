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
 * <p><strong>WARNING:</strong> AS THE CONFIGURATION SYSTEM IS NOT COMPLETE, THIS
 * CLASS IS SUBJECT TO DRASTIC CHANGES IN THE NEAR FUTURE. 
 * If this issue: https://github.com/JeyDotC/Hirudo/issues/3 is closed, then 
 * ignore this warning</p>.
 * 
 * <p>This class brings support for configuration
 * based on the host CMS.</p>
 *
 * @author JeyDotC
 */
abstract class AppConfig {

    /**
     * Creates a new AppConfig and loads the current configuration. 
     */
    function __construct() {
        $this->load();
    }

    /**
     * Load the configuration data.
     */
    protected abstract function load();

    /**
     * Gets a value from the collected configuration data. 
     * 
     * @param string $key The key that identifies the value in config.
     * @param mixed $default A default value which is returned if there is no value associated to the given key.
     * 
     * @return mixed The value associated to the key. If the config value has inner
     * data, the returned value will be an array.
     */
    public abstract function get($key, $default = null);
    
    public abstract function loadApp($appName);
    
    /**
     * 
     */
    public abstract function loadValues(array $values);

    /**
     * 
     */
    public abstract function has($key);

    public final function __set($name, $value) {
        throw new Exception("The config is a read only object.");
    }

    /**
     * Wraps the get() method making possible to request configuration data this way:
     * <code>config->aConfigKey</code>
     * 
     * @param string $name 
     * @return mixed 
     */
    public final function __get($name) {
        return $this->get($name);
    }

}

?>
