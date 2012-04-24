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

use Hirudo\Core\Util\RequestBinder;
use Hirudo\Core\Annotations\Import;

/**
 * This object represents the actual request.
 *
 * @author Virtualidad
 *
 */
abstract class Request {

    private $requestAttributes = array();

    /**
     *
     * @var Session
     */
    private $session;

    function __construct() {
        
    }

    public function setAttribute($key, $value) {
        $this->requestAttributes[$key] = $value;
    }

    public function getAttribute($key, $default = null) {
        return $this->getVar($this->requestAttributes, $key, $default);
    }

    public function removeAttribute($key) {
        $attr = null;
        if (isset($this->requestAttributes[$key])) {
            $attr = $this->requestAttributes[$key];
            unset($this->requestAttributes[$key]);
        }

        return $attr;
    }

    public function bind(&$object, $bindings = null) {
        $binder = new RequestBinder();
        $binder->bind($object, $bindings);
    }

    /**
     * Retrieves a value from $_GET.
     * 
     * @param string $name The $_GET index.
     * @param mixed $default A default value that will be returned if $_GET doesn't have a value for the given index.
     * @return mixed The value corresponding to the $name index in the $_GET array.
     */
    public abstract function get($name, $default = null);

    public abstract function post($name, $default = null);

    public abstract function file($name, $default = null);

    public abstract function cookie($name, $default = null);

    public abstract function env($name, $default = null);

    public abstract function server($name, $default = null);

    public abstract function getURI();

    /**
     * Creates a ModuleCall from request parameters, generally from the URL,
     * the way this done depends on how this class interprets the URLs. 
     * 
     * @return ModuleCall An instance of ModuleCall based on this class interpretation of the URL
     */
    public abstract function buildModuleCall();

    /**
     * Determines if there is any data in the $_POST array.
     * @return bool <code>true</code> if there is POST data.
     */
    public abstract function submitted();

    protected function getVar(&$collection, $index, $default = null) {
        $result = $default;

        if (array_key_exists($index, $collection)) {
            $result = $collection[$index];
        }

        return $result;
    }

    /**
     *
     * @return Session
     */
    public function getSession() {
        return $this->session;
    }

    /**
     *
     * @param Session $session
     *
     * @Import(id="session")
     */
    public function setSession(Session $session) {
        $this->session = $session;
    }

}