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
 * This object represents the current request.
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

    /**
     * Stores a value in memory so it can be accesed "gloablly".
     * 
     * @param string $key A key to identify the value.
     * @param mixed $value The value.
     */
    public function setAttribute($key, $value) {
        $this->requestAttributes[$key] = $value;
    }

    /**
     * Gets an in-memory value from the current request which is stored with
     * the setAttribute() method.
     * 
     * @param string $key The key that identifies the stored value.
     * @param mixed $default A default value which is returned if there is no value associated to the given key.
     * 
     * @return mixed The value associated to the key.
     */
    public function getAttribute($key, $default = null) {
        return $this->getVar($this->requestAttributes, $key, $default);
    }

    /**
     * Removes an in-memory stored value from this request.
     * 
     * @param string $key The key corresponding to the value to be removed.
     * @return mixed The value that has been removed. 
     */
    public function removeAttribute($key) {
        $attr = null;
        if (isset($this->requestAttributes[$key])) {
            $attr = $this->requestAttributes[$key];
            unset($this->requestAttributes[$key]);
        }

        return $attr;
    }

    /**
     * TODO: #desition Remove this method?
     * 
     * @param type $object
     * @param type $bindings 
     */
    public function bind(&$object, $bindings = null) {
        $binder = new RequestBinder();
        $binder->bind($object, $bindings);
    }

    /**
     * Retrieves a value from the GET parameters.
     * 
     * @param string $name The GET index.
     * @param mixed $default A default value that will be returned if GET doesn't have a value for the given index.
     * @return mixed The value corresponding to the $name index in the GET array.
     */
    public abstract function get($name, $default = null);

    /**
     * Retrieves a value from the POST parameters.
     * 
     * @param string $name The POST index.
     * @param mixed $default A default value that will be returned if POST doesn't have a value for the given index.
     * @return mixed The value corresponding to the $name index in the POST array.
     */
    public abstract function post($name, $default = null);

    /**
     * Retrieves a value from the FILE parameters.
     * 
     * @param string $name The FILE index.
     * @param mixed $default A default value that will be returned if FILE doesn't have a value for the given index.
     * @return mixed The value corresponding to the $name index in the FILE array.
     */
    public abstract function file($name, $default = null);

    /**
     * Retrieves a value from the COOKIE parameters.
     * 
     * @param string $name The COOKIE index.
     * @param mixed $default A default value that will be returned if COOKIE doesn't have a value for the given index.
     * @return mixed The value corresponding to the $name index in the COOKIE array.
     */
    public abstract function cookie($name, $default = null);

    /**
     * Retrieves a value from the ENV parameters.
     * 
     * @param string $name The ENV index.
     * @param mixed $default A default value that will be returned if ENV doesn't have a value for the given index.
     * @return mixed The value corresponding to the $name index in the ENV array.
     */
    public abstract function env($name, $default = null);

    /**
     * Retrieves a value from the SERVER parameters.
     * 
     * @param string $name The SERVER index.
     * @param mixed $default A default value that will be returned if SERVER doesn't have a value for the given index.
     * @return mixed The value corresponding to the $name index in the SERVER array.
     */
    public abstract function server($name, $default = null);

    /**
     * Gets the current URI as a string.
     * 
     * @return string the current URI.
     */
    public abstract function getURI();

    /**
     * Gets the current HTTP method (GET, POST, PUT, DELETE).
     * 
     * @return string Returns a string with the current HTTP method. 
     */
    public function method() {
        return $this->server("REQUEST_METHOD", "GET");
    }

    /**
     * Creates a ModuleCall from request parameters, generally from the URL,
     * the way this done depends on how this class interprets the URLs. 
     * 
     * @return ModuleCall An instance of ModuleCall based on this class interpretation of the URL
     */
    public function buildModuleCall() {
        $parts = explode("/", $this->get("h"));

        $app = isset($parts[0]) ? $parts[0] : "";
        $module = isset($parts[1]) ? $parts[1] : "";
        $task = isset($parts[2]) ? $parts[2] : "index";

        return new ModuleCall($app, $module, $task);
    }

    /**
     * Determines if there is any data in the $_POST array.
     * 
     * @deprecated This method looks to be useless
     * @return bool <code>true</code> if there is POST data.
     */
    public abstract function submitted();

    /**
     * An utility method that simply returns tha value associated to the given
     * index or the given default value if there is no value associated to the
     * index.
     * 
     * @param array $collection The conllection from which the value will be requested.
     * @param string $index The index for the requested value.
     * @param mixed $default A default value which is returned if there is no value associated to the given index.
     * 
     * @return mixed The value associated to the given index.
     */
    protected function getVar(&$collection, $index, $default = null) {
        $result = $default;

        if (array_key_exists($index, $collection)) {
            $result = $collection[$index];
        }

        return $result;
    }

    /**
     * Gets the current session object.
     * 
     * @return Session The current session.
     */
    public function getSession() {
        return $this->session;
    }

    /**
     * @param Session $session
     * @Import(id="session")
     */
    public function setSession(Session $session) {
        $this->session = $session;
    }

}