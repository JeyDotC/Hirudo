<?php

namespace Sample\Plugins;

use Symfony\Component\EventDispatcher\Event;
use Hirudo\Core\Events\Annotations\Listen;
/**
 * Description of ModuleEnhablePlugin
 *
 * @author JeyDotC
 */
class SamplePlugin {

    /**
     * 
     * @param \Symfony\Component\EventDispatcher\Event $e
     * @return type
     * 
     * @Listen(to="beforeTask")
     */
    public function doNothing(Event $e) {
        return;
    }

}

?>
