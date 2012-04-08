<?php

namespace SampleApp\Modules;

use Hirudo\Core\Module;

/**
 * Description of ErrorPage
 *
 * @author JeyDotC
 */
class ErrorPage extends Module {

    public function index() {
        $ex = $this->getLastUnhandledException();
        $this->assign("ex", $ex);
        
        $this->display("index");
    }

}

?>
