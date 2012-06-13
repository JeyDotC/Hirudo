<?php

namespace KitchenSink\Modules\Errors;

use Hirudo\Core\Module;

/**
 * This module is called in case of any exception. Or if a module is not found.
 *
 * @author JeyDotC
 */
class Errors extends Module {

    /**
     * This method is called when there is an exception.
     */
    public function index() {
        /**
         * Here you can see one of the Hirudo's shorcuts, is an instance of the
         * ModulesContext class. This class holds objects like
         * Session, Request, Config among others. In this case we are accessing to
         * the Current call, which maps the currently requested module and also
         * holds the last occurred exception.
         * 
         * To know more about the objects available in the module see: https://github.com/JeyDotC/Hirudo-docs/blob/master/Hirudo/Core/Module.md#field-detail
         */
        $ex = $this->context->getCurrentCall()->getLastUnhandledException();
        $this->assign("ex", $ex);

        $this->display("index");
    }
    
    /**
     * This method is called when the requested module doesn't exist
     */
    public function notFound() {
        $this->display("404");
    }

}

?>
