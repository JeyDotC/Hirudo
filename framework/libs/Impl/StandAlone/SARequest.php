<?php

namespace Hirudo\Libs\Impl\StandAlone;

use Hirudo\Core\Context\Request as Request;
use Hirudo\Core\Annotations\Export as Export;

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

}

?>
