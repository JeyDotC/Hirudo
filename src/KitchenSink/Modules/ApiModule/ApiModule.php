<?php

namespace KitchenSink\Modules\ApiModule;

use Hirudo\Core\Annotations\HttpMethod;
use Hirudo\Core\Extensions\WebApi\Annotations\Api;
use Hirudo\Core\Module;
use KitchenSink\Models\Entities\Foo;

/**
 * Description of ApiModule
 *
 * @author JeyDotC
 */
class ApiModule extends Module {

    /**
     *  
     * @return array<Foo>
     * 
     * @Api
     * @HttpMethod("GET")
     */
    function index() {
        return $this->component("Foo")->getAll();
    }

    /**
     *  
     * @return Foo
     * 
     * @Api
     * @HttpMethod("GET")
     */
    public function view($id) {
        return $this->component("Foo")->get($id);
    }
    
    /**
     * 
     * @param \KitchenSink\Models\Entities\Foo $foo
     * 
     * @Api
     * @HttpMethod("POST")
     */
    public function save(Foo $foo) {
        $this->component("Foo")->save($foo);
    }
    
    /**
     * 
     * @param int $id
     * 
     * @Api
     * @HttpMethod("DELETE")
     */
    public function remove($id) {
        $this->component("Foo")->remove($id);
    }

}

?>
