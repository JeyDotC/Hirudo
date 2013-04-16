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

namespace Hirudo\Impl\Joomla\V15;

use Hirudo\Core\Context\Request as Request;
use Hirudo\Core\Context\ModuleCall;
use Hirudo\Core\Annotations\Export;

/**
 * Description of JoomlaRequest
 *
 * @author JeyDotC
 * 
 * @Export(id="request", factory="instance")
 * 
 */
class JoomlaRequest extends Request {

    /**
     *
     * @var JoomlaRequest
     */
    private static $instance;

    /**
     *
     * @return 
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new JoomlaRequest();
        }

        return self::$instance;
    }

    public function get($name, $default = null) {
        return \JRequest::getVar($name, $default, "GET");
    }

    public function post($name, $default = null) {
        return \JRequest::getVar($name, $default, "POST");
    }

    public function file($name, $default = null) {
        return \JRequest::getVar($name, $default, "FILES");
    }

    public function cookie($name, $default = null) {
        return \JRequest::getVar($name, $default, "COOKIE");
    }

    public function env($name, $default = null) {
        return \JRequest::getVar($name, $default, "ENV");
    }

    public function server($name, $default = null) {
        return \JRequest::getVar($name, $default, "SERVER");
    }

    public function getURI() {
        return \JRequest::getURI();
    }

    public function submitted() {
        return isset($_POST) && count($_POST) > 0;
    }

}

?>
