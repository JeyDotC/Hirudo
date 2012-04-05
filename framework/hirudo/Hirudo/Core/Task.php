<?php

namespace Hirudo\Core;

/**
 * Description of Task
 *
 * @author JeyDotC
 */
class Task {

    /**
     *
     * @var \ReflectionMethod
     */
    private $reflectionMethod;
    private $getParams = array();
    private $postParams = array();
    private $paramValues = array();

    function __construct(\ReflectionMethod $reflectionMethod) {
        $this->reflectionMethod = $reflectionMethod;
        foreach ($this->reflectionMethod->getParameters() as /* @var $parameter \ReflectionParameter */$parameter) {

            $this->paramValues[$parameter->name] = $parameter->isOptional() ? $parameter->getDefaultValue() : null;

            if (!$parameter->isArray() && is_null($parameter->getClass())) {
                $this->getParams[] = $parameter;
            } else {
                $this->postParams[] = $parameter;
            }
        }
    }

    public function getGetParams() {
        return $this->getParams;
    }

    public function getPostParams() {
        return $this->postParams;
    }

    public function setParamValue($paramName, $value) {
        $this->paramValues[$paramName] = $value;
    }
    
    public function getParamValue($paramName) {
        return $this->paramValues[$paramName];
    }
    
    public function invoke($object) {
        $this->reflectionMethod->invokeArgs($object, $this->paramValues);
    }

}

?>
