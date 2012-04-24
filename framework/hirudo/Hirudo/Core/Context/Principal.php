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

abstract class Principal {

    private $name;
    private $credentials;
    private $permissions = array();
    private $data;

    function __construct() {
        $this->data = new UserExtraData();
    }

    public abstract function isAnonimous();

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getCredential() {
        return $this->credentials;
    }

    public function setCredential($credential) {
        $this->credentials = $credential;
    }

    public function getPermissions() {
        return $this->permissions;
    }

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
