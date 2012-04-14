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
        $add = $this->route->action("add");
        /**
         * This way we create an Url to another module in the same application. 
         */
        $returnUrl = $this->route->moduleAction("FrontPage");
        /**
         * It's not mandatory for a module to render a view, a simple echo
         * is also enough.
         */
        echo "<div><a href='$returnUrl'>Get Back</a></div>";
        echo "
            <form method='post' action='$add'>
                <label>Name: </label> <input type='text' name='name[0]' placeholder='some name'/>
                <input type='submit' value='add'/>
            </form>
            ";
        var_dump($this->component("DbTest")->getAll());
    }

    /**
     * 
     * @param array $name 
     */
    public function add(array $name) {
        $this->component("DbTest")->add($name[0]);
        $this->index();
    }

}

?>
