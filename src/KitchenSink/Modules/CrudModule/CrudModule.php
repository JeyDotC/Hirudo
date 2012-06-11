<?php

namespace KitchenSink\Modules;

use Hirudo\Core\Module;
use KitchenSink\Models\Entities\Foo;
use Hirudo\Core\Util\Message;
use Hirudo\Core\Annotations\HttpPost;

class CrudModule extends Module {

    public function index() {
        $foos = $this->component("Foo")->getAll();

        $this->assign("fooList", $foos);

        $this->display("index");
    }

    public function view($id) {
        $foo = $this->component("Foo")->get($id);

        $this->assign("foo", $foo);

        $this->display("view");
    }

    public function create() {
        $this->assign("action", $this->route->action("save"));
        
        $this->display("create");
    }

    public function update($id) {
        $foo = $this->component("Foo")->get($id);

        $this->assign("foo", $foo);
        $this->assign("action", $this->route->action("save"));

        $this->display("update");
    }
    
    public function remove($id) {
        $this->component("Foo")->remove($id);
        
        $this->addMessage(new Message("The Foo have been removed.", "Goodbye, Foo", Message::SUCCESS));
        
        $this->index();
    }

    /**
     * 
     * @param \KitchenSink\Models\Entities\Foo $foo
     * 
     * @HttpPost
     */
    public function save(Foo $foo) {
        $this->component("Foo")->save($foo);
        
        $this->addMessage(new Message("Foo have been saved.", "Saved!", Message::SUCCESS));
        
        $this->index();
    }

}

?>
