<?php

namespace Hirudo\Core\Events;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Description of BeforeTaskEventListener
 *
 * @author JeyDotC
 */
abstract class BeforeTaskEventListener implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        return array(BeforeTaskEvent::NAME => "onBeforeTask");
    }
    
    //A wrapper function for future cool stuff.
    public function onBeforeTask(BeforeTaskEvent $e){
        $this->beforeTask($e);
    }
    
    protected abstract function beforeTask(BeforeTaskEvent $e);

}

?>
