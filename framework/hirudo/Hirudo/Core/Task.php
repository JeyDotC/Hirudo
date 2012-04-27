<?php

/**
 * «Copyright 2012 Jeysson José Guevara Mendivil(JeyDotC)» 
 * 
 * This file is part of Hirudo.
 * 
 * Hirudo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 *  Hirudo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 * 
 *  You should have received a copy of the GNU General Public License
 *  along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Core;

use Doctrine\Common\Annotations\AnnotationReader;
use Hirudo\Core\Annotations\HttpPost;

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
    private $isPostOnly = false;

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

        $this->isPostOnly = $this->annotationReader->getMethodAnnotation($reflectionMethod, "Hirudo\Core\Annotations\HttpPost") != null;

        foreach ($this->reflectionMethod->getParameters() as /* @var $parameter \ReflectionParameter */$parameter) {

            $this->paramValues[$parameter->name] = $parameter->isOptional() ? $parameter->getDefaultValue() : null;

            if (!$parameter->isArray() && is_null($parameter->getClass()) && !$this->isPostOnly) {
                $this->getParams[] = $parameter;
            } else {
                $this->postParams[] = $parameter;
            }
        }
    }

    public function getName() {
        return $this->reflectionMethod->name;
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

    public function isPostOnly() {
        return $this->isPostOnly;
    }

}

?>
