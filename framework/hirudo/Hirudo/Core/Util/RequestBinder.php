<?php

namespace Hirudo\Core\Util;

use Hirudo\Serialization\ArrayToEntityConverter;
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

    public function bind(&$object, $bindings = null) {
        $request = ModulesContext::instance()->getRequest();

        if (!is_array($bindings)) {
            $bindings = $request->post("__bindings");
        }

        $this->converter->convert($bindings, $object);
    }

}

?>
