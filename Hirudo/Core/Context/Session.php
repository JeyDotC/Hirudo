<?php
namespace Hirudo\Core\Context;

final class SessionStates extends \PseudoEnum{
    const ACTIVE = 'active';
    const EXPIRED = 'expired';
    const DESTROYED = 'destroyed';
    const ERROR = 'error';
} 
/**
 * Description of Session
 *
 * @author Virtualidad
 */
interface Session {

    public function id();

    public function has($key);

    public function put($key, $value);

    public function &get($key, $default=null);

    public function remove($key);

    public function state();
}

?>
