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
 * Hirudo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Impl\Moodle;

use Hirudo\Core\Context\Session as Session;
use Hirudo\Core\Context\SessionStates;

/**
 * @Hirudo\Core\Annotations\Export(id="session")
 */
class MoodleSession implements Session {

    public function &get($key, $default = null) {
		$result = $this->has($key) ? $_SESSION[$key] : $default;
        return $result;
    }

    public function has($key) {
        return array_key_exists($key, $_SESSION);
    }

    public function id() {
        return session_id();
    }

    public function put($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function remove($key) {
        $oldValue = $this->get($key);
        unset($_SESSION[$key]);
        return $oldValue;
    }

    public function state() {
        $state = SessionStates::ACTIVE;
        if (session_status() == PHP_SESSION_NONE) {
            $state = SessionStates::EXPIRED;
        }

        return $state;
    }

}

?>
