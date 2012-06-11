<?php

namespace KitchenSink\Modules;

use Hirudo\Core\Module;

/**
 * Description of ErrorPage
 *
 * @author JeyDotC
 */
class Errors extends Module {

    public function index() {
        $ex = $this->context->getCurrentCall()->getLastUnhandledException();
        $this->assign("ex", $ex);

        $this->display("index");
    }
    
    public function notFound() {
        $this->display("404");
    }

}

?>
