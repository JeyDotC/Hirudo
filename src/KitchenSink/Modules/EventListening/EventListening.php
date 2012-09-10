<?php

namespace KitchenSink\Modules\EventListening;

use Hirudo\Core\Context\ModuleCall;
use Hirudo\Core\Events\AfterTaskEvent;
use Hirudo\Core\Events\BeforeTaskEvent;
use Hirudo\Core\Events\Annotations\Listen;
use Hirudo\Core\Module;

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
     */
    function goToSomwhereElse(BeforeTaskEvent $e) {
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
     * @Listen(to="afterTask", constraints={"KitchenSink::CrudModule::save"})
     */
    function listenToSpecificCall(AfterTaskEvent $e) {
        $e->getDocument()->find("#Content")
                ->append("<div style='color:#DDDDDD;'>This content is added by an event listener, to know more about them look at the <strong>KitchenSink\Modules\EventListening\EventListening</strong> class </div>");
    }

}

?>
