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

namespace Hirudo\Impl\Moodle;

use Hirudo\Core\Context\Request as Request,
    Hirudo\Core\Context\ModuleCall;
use Hirudo\Core\Annotations\Export;

/**
 * Description of MoodleRequest
 *
 * @author JeyDotC
 * 
 * @Export(id="request", factory="instance")
 */
class MoodleRequest extends Request {

    /**
     *
     * @var MoodleRequest
     */
    private static $instance;

    /**
     *
     * @return MoodleRequest
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new MoodleRequest();
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
        return $this->getVar($_FILES, $name, $default);
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
}

?>
