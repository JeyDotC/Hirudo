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
 * A collection of data asociated to the user.
 * 
 * TODO: This class is an absurdity!
 */
class UserExtraData {

    private $data = array();

    function add($key, $value) {
        $this->data[$key] = $value;
        return $this;
    }

    function get($key) {
        return $this->data[$key];
    }

    function has($key) {
        return isset($this->data[$key]);
    }

}

/**
 * This class represents the current user. 
 * 
 * TODO: setter methods look unnecessary
 */
abstract class Principal {

    private $name;
    private $credentials;
    private $permissions = array();
    private $data;

    /**
     * Creates a ne Principal object. 
     */
    function __construct() {
        $this->data = new UserExtraData();
    }

    /**
     * Determines if this user is logged in.
     * 
     * @return boolean True if this user is logged in, false otherwise.
     */
    public abstract function isAnonimous();

    /**
     * Gets the current user name. The name with which the user logs in.
     * 
     * @return string the current user name. 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets the current user name.
     * 
     * @param string $name The new user name.
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Usually the user password, this may be null depending of the security
     * system implementation.
     * 
     * @return type 
     */
    public function getCredential() {
        return $this->credentials;
    }

    /**
     * Sets the current user's credential.
     * 
     * @param string $credential The new credential.
     */
    public function setCredential($credential) {
        $this->credentials = $credential;
    }

    /**
     * Gets the array of roles associated to this user.
     * 
     * @return array The list of roles associated to this user. 
     */
    public function getPermissions() {
        return $this->permissions;
    }

    /**
     * Sets the array of roles associated to this user.
     * 
     * @param array $permissions A new list of roles associated to this user. 
     */
    public function setPermissions($permissions) {
        $this->permissions = $permissions;
    }

    /**
     *
     * @return UserExtraData
     */
    public function getData() {
        return $this->data;
    }

}

?>
