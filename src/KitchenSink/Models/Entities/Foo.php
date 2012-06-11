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
