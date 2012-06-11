<?php

namespace KitchenSink\Models\Components;

use Hirudo\Core\Context\ModulesContext;
use KitchenSink\Models\Entities\Foo;
use KitchenSink\Models\Entities\Bar;

/**
 * A component that stores entities in session, normally you should use
 * a component that stores entities to the database.
 *
 * @author JeyDotC
 */
class FooComponent {
    private $session;

    function __construct() {
        $this->session = ModulesContext::instance()->getSession();
    }

    public function getAll() {
        return unserialize($this->session->get("FooList", serialize(array())));
    }

    public function get($id) {
        $foos = $this->getAll();
        return $foos[$id];
    }

    public function save(Foo $foo) {
        if (!$foo->getId()) {
            $foo->setId($this->createId());
        }

        if (!$foo->getBar()->getId()) {
            $foo->getBar()->setId($this->createId());
        }

        $foos = $this->getAll();
        $foos[$foo->getId()] = $foo;
        $this->session->put("FooList", serialize($foos));
    }

    public function remove($id) {
        $foos = $this->getAll();
        unset($foos[$id]);
        $this->session->put("FooList", serialize($foos));
    }

    private function createId() {
        $id = $this->session->get("Sequence", 0);
        $id++;
        $this->session->put("Sequence", $id);
        return $id;
    }

}

?>
