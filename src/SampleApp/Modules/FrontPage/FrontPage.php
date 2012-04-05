<?php

namespace SampleApp\Modules;

use Hirudo\Core\Module;

/**
 * Description of FrontPage
 *
 * @author JeyDotC
 */
class FrontPage extends Module {

    public function index($name = "") {
        $this->assign("name", $name);
        
        $this->display("index");
    }

}

?>
