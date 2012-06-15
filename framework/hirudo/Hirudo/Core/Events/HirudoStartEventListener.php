<?php

namespace Hirudo\Core\Events;

/**
 * Description of HirudoStartEventListener
 *
 * @author JeyDotC
 */
abstract class HirudoStartEventListener extends HirudoEventListenerBase {

    protected static function eventName() {
        return HirudoStartEvent::NAME;
    }

    protected static function methodName() {
        return "onHirudoStart";
    }

    public abstract function onHirudoStart(HirudoStartEvent $e);
}

?>
