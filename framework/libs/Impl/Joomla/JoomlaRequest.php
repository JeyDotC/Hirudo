<?php

namespace Hirudo\Libs\Impl\Joomla;

use Hirudo\Core\Context\Request as Request;

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
        return JRequest::getVar($name, $default, "GET");
    }

    public function post($name, $default = null) {
        return JRequest::getVar($name, $default, "POST");
    }

    public function file($name, $default = null) {
        return JRequest::getVar($name, $default, "FILES");
    }

    public function cookie($name, $default = null) {
        return JRequest::getVar($name, $default, "COOKIE");
    }

    public function env($name, $default = null) {
        return JRequest::getVar($name, $default, "ENV");
    }

    public function server($name, $default = null) {
        return JRequest::getVar($name, $default, "SERVER");
    }

    public function getURI() {
        return JRequest::getURI();
    }

    public function submitted() {
        return isset($_POST) && count($_POST) > 0;
    }

}

?>
