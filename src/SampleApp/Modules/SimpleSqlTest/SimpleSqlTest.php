<?php

namespace SampleApp\Modules;

use Hirudo\Core\Module;

/**
 * Description of SimpleSqlTest
 *
 * @author JeyDotC
 */
class SimpleSqlTest extends Module {

    public function index() {
        /**
         * This way we create an Url to another module in the same application. 
         */
        $returnUrl = $this->route->moduleAction("FrontPage");
        /**
         * It's not mandatory for a module to render a view, a simple echo
         * is also enough.
         */
        echo "<div><a href='$returnUrl'>Get Back</a></div>";
        var_dump($this->component("DbTest")->getAll());
    }

}

?>
