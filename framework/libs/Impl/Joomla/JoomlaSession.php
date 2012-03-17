<?php

namespace Hirudo\Libs\Impl\Joomla;

use Hirudo\Core\Context\Session as Session;

/**
 * 
 * @Export(id="session"Class")
 */
class JoomlaSession implements Session {

    public function id() {
        return $this->getSessionObject()->getId();
    }

    /**
     *
     * @return JSession
     */
    private function &getSessionObject() {
        $session = JFactory::getSession();
        return $session;
    }

    public function &get($key, $default = null) {
        $object = $this->getSessionObject()->get($key, $default);
        return $object;
    }

    public function put($key, $value) {
        return $this->getSessionObject()->set($key, $value);
    }

    public function remove($key) {
        return $this->getSessionObject()->clear($key);
    }

    public function has($key) {
        return $this->getSessionObject()->has($key);
    }

    public function state() {
        return $this->getSessionObject()->getState();
    }

}

?>
