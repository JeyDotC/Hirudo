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
 * A class to create internal routes. An instance of this class can be bound
 * to a certain module in a certain appplication.
 *
 * @author Virtualidad
 */
abstract class Routing {

    private $appName = "";
    private $moduleName = "";

    /**
     * Creates a route to the given task using the current application name
     * and the current module name.
     * 
     * @param string $task The task to be executed.
     * @param array $params An array of key/value pairs of values to be appended as URL values.
     * 
     * @return string The resulting absolute URL.
     */
    public function action($task, array $params = array()) {
        return $this->moduleAction($this->moduleName, $task, $params);
    }

    /**
     * Creates a route to the given task using the current application name
     * and the given module name.
     * 
     * @param string $module A module name that belongs to the current application.
     * @param string $task The task to be executed.
     * @param array $params An array of key/value pairs of values to be appended as URL values.
     * 
     * @return string The resulting absolute URL.
     */
    public function moduleAction($module, $task = "index",
            array $params = array()) {
        return $this->appAction($this->appName, $module, $task, $params);
    }

    /**
     * Creates a route to the given task using the given application name
     * and the given module name.
     * 
     * @param string $app Aa application name.
     * @param string $module A module name that belongs to the given application.
     * @param string $task The task to be executed.
     * @param array $params An array of key/value pairs of values to be appended as URL values.
     * 
     * @return string The resulting absolute URL.
     */
    public abstract function appAction($app, $module, $task = "index",
            array $params = array());

    /**
     * Gets the current base URL.
     * 
     * @return string The current base URL 
     */
    public abstract function getBaseURL();

    /**
     * Makes an HTTP redirect to the given absolute URL.
     * 
     * @param string $url The absolute URL to make the redirection.
     */
    public abstract function redirect($url);

    /**
     * Gets the current module name.
     * 
     * @return string The name of the current module. 
     */
    public function getModuleName() {
        return $this->moduleName;
    }

    /**
     * Sets the current module name.
     * 
     * @param string $moduleName The name of the module.
     */
    public function setModuleName($moduleName) {
        $this->moduleName = $moduleName;
    }

    /**
     * Gets the current application name.
     * 
     * @return string The current app name.
     */
    public function getAppName() {
        return $this->appName;
    }
    
    /**
     * Sets the current application name.
     * 
     * @param string $appName The current application name.
     */
    public function setAppName($appName) {
        $this->appName = $appName;
    }

}

?>
