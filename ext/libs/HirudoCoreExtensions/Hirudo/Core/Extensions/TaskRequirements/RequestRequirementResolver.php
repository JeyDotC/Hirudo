<?php

namespace Hirudo\Core\Extensions\TaskRequirements;

use Hirudo\Core\Context\ModulesContext;
use ReflectionParameter;

/**
 * Description of BasicRequestResolver
 *
 * @author JeyDotC
 */
class RequestRequirementResolver implements RequirementResolverInterface {

    private $request;

    function __construct() {
        $this->request = ModulesContext::instance()->getRequest();
    }

    public function resolve(ReflectionParameter $param, $source) {
        $defaultValue = $param->isOptional() ? $param->getDefaultValue() : null;
        $from = strtolower($source);
        $result = null;

        if ($param->getClass() != null) {
            $result = $param->getClass()->newInstance();
            $this->request->bind($result, $this->request->$from($param->name));
        } else {
            $result = $this->request->$from($param->name, $defaultValue);
        }
        
        return $result;
    }

    public function suports($source) {
        return is_string($source) && in_array(strtolower($source), array(
                    "get",
                    "post",
                    "cookie",
                    "env",
                    "server"));
    }

}

?>
