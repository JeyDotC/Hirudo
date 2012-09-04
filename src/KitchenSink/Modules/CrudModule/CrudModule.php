<?php

namespace KitchenSink\Modules\CrudModule;

use Hirudo\Core\Module;
use KitchenSink\Models\Entities\Foo;
use Hirudo\Core\Util\Message;
use Hirudo\Core\Annotations\HttpPost;

/**
 * This module represents a tipical Cread, Read, Update, Delete use case with the
 * Foo entity as the main subject.
 */
class CrudModule extends Module {

    /**
     * Lists all entities.
     */
    public function index() {
        /**
         * Retreives all foo objects from the FooComponent class.
         * 
         * Note that calling the 'component' method, the module instances a 
         * FooComponent object(If it haven't been instanced before), and returns
         * it. Also note that the object is called by just Foo, the module internally
         * appends 'Component' to the name.
         * 
         * The class FooComponent is at KitchenSink/Models/Components folder.
         */
        $foos = $this->component("Foo")->getAll();

        /**
         * Here we assign our list of foos to the view. They will be available as
         * the $fooList variable in the template. 
         */
        $this->assign("fooList", $foos);

        return $this->display("index");
    }

    /**
     * This method shows a details view for a foo with the given id.
     * 
     * Wait a second, where is that '$id' parameter coming from? well, Hirudo 
     * resolves the parameters which has no type hinting from GET, thus, if there
     * is a value in the GET parameters which name matches 'id', then the $id param
     * is set to that value, other wise, the default value is used, and if there is no
     * default value, null is used.
     * 
     * Anyway, you can also programatically get the values from the GET this way:
     * 
     * $myGetValue = $this->request->get("id");
     * 
     * @param string $id
     */
    public function view($id) {

        $foo = $this->component("Foo")->get($id);

        $this->assign("foo", $foo);

        return $this->display("view");
    }

    /**
     * Displays view to create a new Foo.
     */
    public function create() {
        /**
         * Note that, in this case, we are programatically creating a URL, instead
         * of using the {url} smarty function in the template.
         * 
         * Every module in Hirudo has an instance of Hirudo/Core/Context/Routing
         * named 'route'.
         * 
         * To know more about Hirudo routing see: https://github.com/JeyDotC/Hirudo-docs/blob/master/Hirudo/Core/Context/Routing.md 
         */
        $this->assign("action", $this->route->action("save"));

        return $this->display("create");
    }

    /**
     * Displays the foo editing page.
     * 
     * @param type $id
     */
    public function update($id) {
        $foo = $this->component("Foo")->get($id);

        $this->assign("foo", $foo);
        $this->assign("action", $this->route->action("save"));

        return $this->display("update");
    }

    /**
     * Removes a Foo
     * 
     * @param type $id
     */
    public function remove($id) {
        $this->component("Foo")->remove($id);

        $this->addMessage(new Message("The Foo have been removed.", "Goodbye, Foo", Message::SUCCESS));

        /**
         * In this case we don't use a display call, instead, we can call another method
         * in the same module.
         */
        return $this->index();
    }

    /**
     * Saves a foo.
     * 
     * Note the presence of a type hinted $foo param. For these cases, the parameter
     * is resolved from post by obtaining an array which name coincides with the
     * param name. The properties are set using the keys of such array.
     * 
     * Also note the presence of the @HttpPost annotation. That annotation indicates
     * that this method only accepts POST requests. Any atempt to access this method
     * via GET, will cause an exception.
     * 
     * @param Foo $foo
     * 
     * @HttpPost
     */
    public function save(Foo $foo) {
        $this->component("Foo")->save($foo);

        $this->addMessage(new Message("The foo have been saved.", "Saved!", Message::SUCCESS));

        return $this->index();
    }

}

?>
