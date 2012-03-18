<?php

namespace Hirudo\Core\Util;

use Hirudo\Libs\Serialization\ArrayToEntityConverter;
use Hirudo\Core\Context\ModulesContext;
/**
 *
 * @author JeyDotC
 */
class RequestBinder {

    private $converter;

    function __construct() {
        $this->converter = new ArrayToEntityConverter();
    }

    public function bind(&$object) {
        $request = ModulesContext::instance()->getRequest();

        $bindings = $request->post("__bindings");

        $this->converter->convert($bindings, $object);
    }

}

?>
