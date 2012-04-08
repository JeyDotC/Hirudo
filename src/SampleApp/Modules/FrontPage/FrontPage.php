<?php

namespace SampleApp\Modules;

use Hirudo\Core\Module;
use SampleApp\Models\Entities\ComplexObject;

/**
 * This is a sample module.
 *
 * @author JeyDotC
 */
class FrontPage extends Module {

    /**
     * This is the index task, this one is called by default.
     * 
     * @param string $name Variables without type hinting are resolved from GET, using
     * the same name of the parameter, thus, the $name parameter in this function is
     * taken from the 'name' value from get. If there is no such value, the default
     * value is put in it's place, if the parameter has no default value the parameter
     * will have value <code>null</code>
     */
    public function index($name = "") {
        /**
         * Here we generate a Hirudo URL that points to a different action in this 
         * same module.
         */
        $action = $this->route->action("response");
        
        //These variables will be available in the view
        $this->assign("name", $name);
        $this->assign("action", $action);
        $this->assign("exceptionPage", $this->route->action("boomPage"));
        
        /**
         * Display the view named "index", you can also display another view
         * from this module by just giving it's name or even views from another 
         * modules and applications by using this notation: "AppName::ModuleName::viewName"
         */
        $this->display("index");
    }

    /**
     * 
     * @param ComplexObject $myComplexObject <p>Parameters with type hinting are taken from post.
     * The object parameters are built with the post data, to do so just name the fields
     * with the array notation: paramName[attributeName] or use the smarty function {bind to="paramName.attributeName"}
     * See the index.tpl file to look examples of both cases.</p>
     * 
     * <p><strong>Important:</strong> In order to have the inner objects correctly mapped is necesary
     * to type the private attributes with the phpDoc notation:</p>
     * <code>
     *  /**
     *  * @var Fully\Qualified\ClassName
     *  * /
     *  private $myInnerObject
     * </code>
     */
    public function response(ComplexObject $myComplexObject) {
        $this->assign("myObject", $myComplexObject);

        $this->display("response");
    }

    /**
     * This is a task to test how Hirudo manages exceptions.
     * 
     * @throws \Exception 
     */
    public function boomPage() {
        throw new \Exception("This is a test exception!");
    }

}

?>
