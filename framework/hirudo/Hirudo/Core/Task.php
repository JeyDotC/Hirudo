<?php

namespace Hirudo\Core;

use Doctrine\Common\Annotations\AnnotationReader;

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
    private $annotationReader;
    private $getParams = array();
    private $postParams = array();
    private $paramValues = array();

    /**
     *
     * @var Module
     */
    private $module;

    function __construct(\ReflectionMethod $reflectionMethod,
            \Hirudo\Core\Module $owner) {
        $this->annotationReader = new AnnotationReader();
        $this->reflectionMethod = $reflectionMethod;
        $this->module = $owner;
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

    public function invoke() {
        $this->reflectionMethod->invokeArgs($this->module, $this->paramValues);
    }

    public function getTaskAnnotations() {
        return $this->annotationReader->getMethodAnnotations($this->reflectionMethod);
    }

    public function getTaskAnnotation($annotationName) {
        return $this->annotationReader->getMethodAnnotation($this->reflectionMethod, $annotationName);
    }

    /**
     *
     * @return Module
     */
    public function getModule() {
        return $this->module;
    }

}

?>
