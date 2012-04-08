<?php

namespace SampleApp\Models\Entities;

/**
 * Description of ComplexObject
 *
 * @author JeyDotC
 */
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

    /**
     *
     * @var SampleApp\Models\Entities\SimpleObject
     */
    private $simpleObject;

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

    public function getSimpleObject() {
        return $this->simpleObject;
    }

    public function setSimpleObject($simpleObject) {
        $this->simpleObject = $simpleObject;
    }

}

?>
