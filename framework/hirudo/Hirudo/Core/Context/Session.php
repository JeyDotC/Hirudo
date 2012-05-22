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
 * An enum representing the different sessions states. 
 */
final class SessionStates extends \PseudoEnum {

    /**
     * Session is active. 
     */
    const ACTIVE = 'active';
    /**
     * Session timeout have been exeeded, normally the session have been
     * already closed in this case. 
     */
    const EXPIRED = 'expired';
    /**
     * The session and all of it's data have been destroyed. 
     */
    const DESTROYED = 'destroyed';
    /**
     * Something went wrong with the session.
     */
    const ERROR = 'error';

}

/**
 * Represents a session, the way the data is stored depends on the implementation.
 *
 * @author Virtualidad
 */
interface Session {

    /**
     * Gets the session id.
     * 
     * @return string The session id. 
     */
    public function id();

    /**
     * Tells if there is a value for the given key.
     * 
     * @param string $key The key for the requested value.
     * 
     * @return boolean True if there is a value for the given key, false otherwise.
     */
    public function has($key);

    /**
     * <p>Sets a value with the given key. If there is a value already, 
     * the former gets replaced.</p>
     * 
     * @param string $key The key for the new value.
     * @param mixed $value The new value.
     */
    public function put($key, $value);

    /**
     * Gets the value for the given key, or the given default value if there is no such
     * value that key.
     * 
     * @param string $key The key corresponding to the requested value.
     * @param mixed $default A default value which is returned if there is no value associated to the given key.
     * 
     * @return mixed The value stored in session or the default value if there is no value associated to the given key.
     */
    public function &get($key, $default = null);

    /**
     * Attempts to remove the object associated to the given key from session.
     * 
     * @param string $key The key for the object to be removed.
     * 
     * @return mixed The previous value. If there were no value for the given key, null is returned.
     */
    public function remove($key);

    /**
     * Gets the current session state.
     * 
     * @return string An string representing the current session state. The string
     * can be any of the constants given in the  SessionStates pseudoenum.
     * 
     * @see SessionStates To know more about the possible session states.
     */
    public function state();
}

?>
