<?php

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
