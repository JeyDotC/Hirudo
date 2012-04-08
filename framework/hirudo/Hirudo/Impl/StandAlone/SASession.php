<?php

namespace Hirudo\Impl\StandAlone;

use Hirudo\Core\Context\Session as Session;
use Hirudo\Core\Context\SessionStates;

require_once 'lib/HTTP/Session2.php';

/**
 * @Hirudo\Core\Annotations\Export(id="session")
 */
class SASession implements Session {

    function __construct() {
        \HTTP_Session2::start();
    }

    public function &get($key, $default = null) {
        return \HTTP_Session2::get($key, $default);
    }

    public function has($key) {
        return isset($_SESSION[$key]);
    }

    public function id() {
        return \HTTP_Session2::detectID();
    }

    public function put($key, $value) {
        \HTTP_Session2::set($key, $value);
    }

    public function remove($key) {
        $oldValue = $this->get($key);
        unset($_SESSION[$key]);
        return $oldValue;
    }

    public function state() {
        $state = SessionStates::ACTIVE;
        if(\HTTP_Session2::isExpired()){
            $state = SessionStates::EXPIRED;
        }
        
        return $state;
    }

}

?>
