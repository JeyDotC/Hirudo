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
 * A class to create internal routes.
 *
 * @author Virtualidad
 */
abstract class Routing {

    private $appName = "";
    private $moduleName = "";

    public function action($task, $params = array()) {
        return $this->moduleAction($this->moduleName, $task, $params);
    }

    public function moduleAction($module, $task = "index", $params = array()) {
        return $this->appAction($this->appName, $module, $task, $params);
    }

    public abstract function appAction($app, $module, $task = "index",
            $params = array());

    public abstract function getBaseURL();

    public abstract function redirect($url);

    public function getModuleName() {
        return $this->moduleName;
    }

    public function setModuleName($moduleName) {
        $this->moduleName = $moduleName;
    }

    public function getAppName() {
        return $this->appName;
    }

    public function setAppName($appName) {
        $this->appName = $appName;
    }

}

?>
