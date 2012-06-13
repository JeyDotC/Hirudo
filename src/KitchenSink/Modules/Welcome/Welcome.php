<?php

namespace KitchenSink\Modules\Welcome;

use Hirudo\Core\Module;
use Hirudo\Core\Util\Message;

/**
 * A welcome Module, this module simply shows how to render a view
 * and how to add notifications which shall be represented by the template.
 *
 * @author JeyDotC
 */
class Welcome extends Module {

    /**
     * Simply renders a view, is come kind of "Hello world".
     */
    public function index() {
        /**
         * Renders the index.tpl file which can be found at the views/ folder of this
         * module. As you can notice, the filename of the view coincides with the
         * method name, this is not mandatory, but is a good convention.
         * 
         * The given view name can be any in the views/ folder of this module. To 
         * call a view from another module, the string should have the format: 
         * "ModuleName::viewName". And to call a view from another application the 
         * string should look like: "AppName::ModuleName::viewName".
         */
        $this->display("index");
    }
    
    /**
     * This method illustrates how to add notifications to the view.
     */
    public function notifications() {
        /**
         * Each notification is added by calling the addMessage method which receives
         * a message object. 
         * 
         * The Message constructor receives a message, a title and a type.
         * 
         * there are several default types like Message::INFO or Message::WARNING, but
         * you can put just any string.
         * 
         * Note that Hirudo doesn't represent the notifications for you, that's because
         * the way a notification is shown varies from one application to another, instead, 
         * you will have an array with all message objects available in the template. For this
         * application, all notifications are represented by the parent template Master.tpl at
         * the assets/smarty-templates/ folder of Hirudo.
         */
        $this->addMessage(new Message("This is an Info message", "Info Message", Message::INFO));
        $this->addMessage(new Message("This is a Warning message", "Warning Message", Message::WARNING));
        $this->addMessage(new Message("This is an Error message", "Error Message", Message::ERROR));
        $this->addMessage(new Message("This is a Success message", "Success Message", Message::SUCCESS));
        
        $this->display("notifications");
    }

    /**
     * This is a task to test how Hirudo manages exceptions.
     * 
     * The exceptions are managed by the module given in the ext/config/Config.yml
     * file in the onError value.
     * 
     * @throws \Exception 
     */
    public function boomPage() {
        throw new \Exception(
                "<p>This exception is thrown intentionally, as you can see, the exceptions are managed by the Errors module.</p>
                <p>The module chosen to be used as the exceptions manager can be configured at the ext/config/Config.yml file by setting the onError value.</p>");
    }

}

?>
