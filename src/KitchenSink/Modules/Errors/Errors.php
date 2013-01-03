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
