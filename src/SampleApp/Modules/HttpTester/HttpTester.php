<?php

namespace SampleApp\Modules;

use Hirudo\Core\Module;

/**
 * Description of HttpTester
 *
 * @author JeyDotC
 */
class HttpTester extends Module {


    public function index() {
        $this->assign("action", "");
        $this->display("index");
    }
    

}

?>
