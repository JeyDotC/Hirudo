<?php

namespace KitchenSink\Modules\ApiModule;

use Hirudo\Core\Annotations\HttpMethod;
use Hirudo\Core\Extensions\WebApi\Annotations\Api;
use Hirudo\Core\Module;
use KitchenSink\Models\Entities\Foo;

/**
 * This module illustrates an api
 * that mimics the CrudModule behavior but having
 * a REST-like interface.
 * 
 * @author JeyDotC
 */
class ApiModule extends Module {

    /**
     * This method returns the list of Foo objects stored in session.
     * 
     * In order to make this method REST-like we need to mark it as
     * such with the Api annotation. The HttpMethod allows to say what HTTP verbs
     * are accepted by it.
     * 
     * Note that we are not specifying the format we are going to return the 
     * data. The format for serialization is determined from the Accept: header
     * parameter, so if you send an HttpRequest with 'Accept: aplication/json' the
     * data returned for this method will be serialized to JSON. 
     * 
     * We aren't even serializing the returned data, that process is done 
     * automatically by the framework, which after choosing a format for serialization
     * atempts to serialize the values returned by this method.
     *  
     * @return array<Foo>
     * 
     * @see HttpMethod
     * 
     * @Api
     * @HttpMethod("GET")
     */
    function index() {
        return $this->component("Foo")->getAll();
    }

    /**
     * Returns the Foo object with the given id.
     * 
     * This is much like the previous one, but we are receiving a value which is
     * resolved from GET
     *  
     * @return Foo
     * 
     * @see HttpMethod
     * 
     * @Api
     * @HttpMethod("GET")
     */
    public function view($id) {
        return $this->component("Foo")->get($id);
    }
    
    /**
     * Saves a new Foo in session.
     * 
     * This method is different from the other two above. First of all, it just
     * accepts POST requests, and secondly, it has a type hinted parameter which
     * is resolved directly from the request payload which will be in some format,
     * like JSON or XML.
     * 
     * The way the request payload's format is determined is similar to the way
     * the response's format is gessed, in this case, Hirudo uses the Content-Type:
     * header variable. So, if we send a request with Content-Type: application/json
     * Hirudo will expect the request payload to be JSON and will attepmt to deserialize
     * it with that asumption.
     * 
     * Here is something important to keep in mind, for now, hirudo accepts one only
     * type-hinted parameter for API methods, not like the normal ones that accepts
     * any number of those.
     * 
     * @param \KitchenSink\Models\Entities\Foo $foo
     * 
     * @see HttpMethod
     * 
     * @Api
     * @HttpMethod("POST")
     */
    public function create(Foo $foo) {
        $this->component("Foo")->save($foo->getDescription(), $foo->getBar()->getName());
    }
    
    /**
     * 
     * @param \KitchenSink\Models\Entities\Foo $foo
     * 
     * @Api
     * @HttpMethod("PUT")
     */
    public function update(Foo $foo) {
        $this->component("Foo")->update($foo->getId(), $foo->getDescription(), $foo->getBar()->getName());
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
