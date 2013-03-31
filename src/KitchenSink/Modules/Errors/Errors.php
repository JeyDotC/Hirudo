<?php

namespace KitchenSink\Modules\Errors;

use Hirudo\Core\Annotations\IgnoreCall;
use Hirudo\Core\Events\Annotations\Listen;
use Hirudo\Core\Events\Annotations\OverridesListener;
use Hirudo\Core\Events\TaskErrorEvent;
use Hirudo\Core\Module;

/**
 * This module is called in case of any exception. Or if a module is not found.
 *
 * @author JeyDotC
 */
class Errors extends Module {

    /**
     * This method is called when there is an exception.
     * 
     * The Listen annotation tells to Hirudo that this method listens to
     * the "taskError" event.
     * 
     * The OverridesListener indicates that this listener overrides any virtual
     * listener with the id "error_listener". An event listener can be declared
     * as virtual which means that it can be overriden for other listeners instead
     * of being called along them.
     * 
     * The IgnoreCall annotation prevents this method from being called through
     * HTTP
     * 
     * @Listen(to="taskError")
     * @OverridesListener(id="error_listener")
     * @IgnoreCall
     */
    public function onError(TaskErrorEvent $e) {
        $ex = $e->getException();
        $this->assign("ex", $ex);

        $e->setResult($this->display("index"));
    }

    /**
     * This method is called when the requested module doesn't exist
     */
    public function notFound() {
        return $this->display("404");
    }

}

?>
