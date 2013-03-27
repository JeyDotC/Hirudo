<?php

namespace KitchenSink\Models\Components;

use Hirudo\Core\Context\ModulesContext;
use KitchenSink\Models\Entities\Foo;
use KitchenSink\Models\Entities\Bar;

/**
 * A component that stores entities in session, normally you should use
 * a component that stores entities to a database.
 * 
 * Hirudo doesn't provide a way of persistence by itself, instead, you can use
 * one or more of the extensions provided by HirudOPlus. One of those is the
 * doctrine binding to Hirudo. Another will be the Restful client.
 * 
 * @author JeyDotC
 */
class FooComponent {

    /**
     *
     * @var \Hirudo\Core\Context\Session
     */
    private $session;

    function __construct() {
        /**
         * In Hirudo, the ModulesContext holds many useful objects and can be
         * accessed from anywhere in the application, like in this case where
         * it's used to access the session object.
         */
        $this->session = ModulesContext::instance()->getSession();
    }

    /**
     * Gets all stored foos.
     * 
     * @return array<Foo>
     */
    public function getAll() {
        return unserialize($this->session->get("FooList", serialize(array())));
    }

    /**
     * Gets a Foo object by id.
     * 
     * @param string $id
     * @return Foo
     */
    public function get($id) {
        $foos = $this->getAll();
        return $foos[$id];
    }

    /**
     * 
     * @param string $description
     * @param string $barName
     */
    public function save($description, $barName) {
        $foo = new Foo();
        $foo->setBar(new Bar());
        $foo->setDescription($description);
        $foo->getBar()->setName($barName);
        
        $this->persist($foo);
    }

    public function update($id, $description, $barName) {
        $foo = $this->get($id);
        $foo->setDescription($description);
        $foo->getBar()->setName($barName);
        
        $this->persist($foo);
    }

    protected function persist(Foo $foo) {
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

    /**
     * Removes a Foo by id.
     * 
     * @param string $id
     */
    public function remove($id) {
        $foos = $this->getAll();
        unset($foos[$id]);
        $this->session->put("FooList", serialize($foos));
    }

    /**
     * Generates a Foo Id.
     * 
     * @return string
     */
    private function createId() {
        $id = $this->session->get("Sequence", 0);
        $id++;
        $this->session->put("Sequence", $id);
        return $id;
    }

}

?>
