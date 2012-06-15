<?php

namespace Hirudo\Core\Events;

use Symfony\Component\EventDispatcher\Event;
use Hirudo\Core\Context\ModulesContext;

/**
 * Description of HirudoEventBase
 *
 * @author JeyDotC
 */
abstract class HirudoEventBase extends Event {

    public static abstract function name();

    /**
     * 
     * @return ModulesContext
     */
    public function getContext() {
        return ModulesContext::instance();
    }

}

?>
