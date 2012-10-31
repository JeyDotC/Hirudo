<?php

namespace KitchenSink\Modules\EventListening;

use Hirudo\Core\Annotations\IgnoreCall;
use Hirudo\Core\Context\ModuleCall;
use Hirudo\Core\Events\AfterTaskEvent;
use Hirudo\Core\Events\Annotations\Listen;
use Hirudo\Core\Events\BeforeTaskEvent;
use Hirudo\Core\Module;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Description of EventListeningModule
 *
 * @author JeyDotC
 */
class EventListening extends Module {

    /**
     * 
     * @param BeforeTaskEvent $e
     * 
     * Hey, Listen!
     * @Listen(to="beforeTask")
     * @IgnoreCall
     */
    function goToSomewhereElse(BeforeTaskEvent $e) {
        $redirect = $this->request->get("redirect", false);
        $redirected = $this->session->get("redirected", false);

        if (!$redirected && $redirect !== false) {
            $e->replaceCall(ModuleCall::fromString($redirect));
            $e->stopPropagation();
            $this->session->put("redirected", true);
        }
    }

    /**
     * 
     * @param AfterTaskEvent $e
     * 
     * @Listen(to="afterTask", constraints={"KitchenSink::EventListening::broadCastEvent"})
     * @IgnoreCall
     */
    function listenToSpecificCall(AfterTaskEvent $e) {
        $e->getDocument()->find("#Content")
                ->append("<p>This content is added by an event listener, to know more about them look at the <strong>KitchenSink\Modules\EventListening\EventListening</strong> class </p>");
    }

    /**
     * 
     * @return string
     */
    function broadCastEvent() {
        $myCustomEvent = $this->context->getDispatcher()->dispatch("myCustomEvent", new GenericEvent("A cool Message!"));
        return $myCustomEvent->getArgument("output");
    }

    /**
     * 
     * @param type $event
     * @Listen(to="myCustomEvent")
     * @IgnoreCall
     */
    function respondToCustomEvent(GenericEvent $event) {
        $this->assign("coolMessage", $event->getSubject());
        $output = $this->display("respond");
        
        $event->setArgument("output", $output);
    }

}

?>
