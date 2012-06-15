<?php

namespace Hirudo\Core\Events;

/**
 * Description of HirudoStartEvent
 *
 * @author JeyDotC
 */
class HirudoStartEvent extends HirudoEventBase {
    const NAME = "hirudoStartEvent";
    
    public static function name() {
        return self::NAME;
    }
}

?>
