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

namespace Hirudo\Impl\Drupal;

use Hirudo\Core\Context\Session;
use Hirudo\Core\Context\SessionStates;
use Hirudo\Core\Annotations\Export;

/**
 * Represents a session, this implementation delegates the session management to
 * the Drupal! JSession class.
 * 
 * @Export(id="session")
 */
class DrupalSession implements Session {

    public function id() {
        return session_id();
    }

    public function &get($key, $default = null) {
        $result = $default;

        if ($this->has($key)) {
            $result = $_SESSION[$key];
        }

        return $result;
    }

    public function put($key, $value) {
        $oldValue = $this->get($key);
        $_SESSION[$key] = $value;
        return $oldValue;
    }

    public function remove($key) {
        $oldValue = $this->get($key);
        unset($_SESSION[$key]);
        return $oldValue;
    }

    public function has($key) {
        return isset($_SESSION[$key]);
    }

    public function state() {
        $state = SessionStates::EXPIRED;
        if (session_status() == PHP_SESSION_ACTIVE) {
            $state = SessionStates::ACTIVE;
        } else if (session_status() == PHP_SESSION_DISABLED) {
            $state = SessionStates::ERROR;
        }

        return $state;
    }

}

?>
