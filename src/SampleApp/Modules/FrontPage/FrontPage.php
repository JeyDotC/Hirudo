<?php

namespace SampleApp\Modules;

use Hirudo\Core\Module;

class ComplexObject {

    /**
     *
     * @var string 
     */
    private $name;
    /**
     *
     * @var string
     */
    private $pass;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPass() {
        return $this->pass;
    }

    public function setPass($pass) {
        $this->pass = $pass;
    }

}

/**
 * Description of FrontPage
 *
 * @author JeyDotC
 */
class FrontPage extends Module {

    /**
     *
     * @param type $name This name is resolved from GET!
     */
    public function index($name = "") {
        $this->assign("name", $name);
        $this->assign("action", $this->route->action("response"));

        $this->display("index");
    }

    /**
     * @param ComplexObject $myComplexObject The complex object is resolved from POST!
     */
    public function response(ComplexObject $myComplexObject) {
        
        $this->assign("myObject", $myComplexObject);
        
        $this->display("response");
    }

}

?>
