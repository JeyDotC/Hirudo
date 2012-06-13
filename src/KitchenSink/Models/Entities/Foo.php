<?php

namespace KitchenSink\Models\Entities;
use KitchenSink\Models\Entities\Bar;

/**
 * Description of Foo
 *
 * @author JeyDotC
 */
class Foo {

    private $id;
    private $description;

    /**
     * Note the use of the fully qualified class name in the var documentation tag, 
     * this is due to a limitation in the \ReflectionClass class.
     * 
     * Doing this part of the class' documentation
     * is important for useful things like the module's parameter solving, seen
     * in the module CrudModule on its method save().
     * 
     * @var KitchenSink\Models\Entities\Bar
     */
    private $bar;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * 
     * @return Bar
     */
    public function getBar() {
        return $this->bar;
    }

    public function setBar(Bar $bar) {
        $this->bar = $bar;
    }

}

?>
