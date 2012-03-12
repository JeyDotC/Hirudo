<?php

namespace Hirudo\Core\Context;

/**
 * This class brings support for configuration
 * based on the host CMS 
 *
 * @author JeyDotC
 */
abstract class AppConfig {

    function __construct() {
        $this->load();
    }

    protected abstract function load();

    public abstract function get($key, $default = null);

    public final function __set($name, $value) {
        throw new Exception("The config is a read only object.");
    }

    public final function __get($name) {
        return $this->get($name);
    }

}

?>
