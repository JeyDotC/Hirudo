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

use Hirudo\Core\Context\Request as Request,
    Hirudo\Core\Context\ModuleCall;
use Hirudo\Core\Annotations\Export;

/**
 * Description of SARequest
 *
 * @author JeyDotC
 * 
 * @Export(id="request", factory="instance")
 */
class SARequest extends Request {

    /**
     *
     * @var SARequest
     */
    private static $instance;

    /**
     *
     * @return SARequest
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new SARequest();
        }

        return self::$instance;
    }

    public function get($name, $default = null) {
        return $this->getVar($_GET, $name, $default);
    }

    public function post($name, $default = null) {
        return $this->getVar($_POST, $name, $default);
    }

    public function file($name, $default = null) {
        return $this->getVar($_FILE, $name, $default);
    }

    public function cookie($name, $default = null) {
        return $this->getVar($_COOKIE, $name, $default);
    }

    public function env($name, $default = null) {
        return $this->getVar($_ENV, $name, $default);
    }

    public function server($name, $default = null) {
        return $this->getVar($_SERVER, $name, $default);
    }

    public function getURI() {
        require_once "lib/JURI.php";
        return JURI::getInstance()->toString();
    }

    public function submitted() {
        return isset($_POST) && count($_POST) > 0;
    }

    public function buildModuleCall() {
        $task = $this->get("task", "index");

        $controllerParts = explode(".", $this->get("controller", ""));
        $app = $controllerParts[0];
        $module = "";

        if (count($controllerParts) > 1) {
            $module = $controllerParts[1];
        }

        return new ModuleCall($app, $module, $task);
    }

}

?>
