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
use Hirudo\Core\Context\ModulesContext;

/**
 * Is a representation of a module's task, it holds the information about the action
 * to be executed and can be used to know which are it's requirements and also 
 * resolve them.
 *
 * @author JeyDotC
 */
class Task {

    /**
     *
     * @var \ReflectionMethod
     */
    private $reflectionMethod;

    /**
     *
     * @var DependencyInjection\DependenciesManager 
     */
    private $dependenciesManager;
    private $params = array();
    private $paramValues = array();

    /**
     *
     * @var Module
     */
    private $module;

    /**
     * Constructs a task.
     * 
     * @param \ReflectionMethod $reflectionMethod The method to be called.
     * @param \Hirudo\Core\Module $owner The module that is the owner of the task.
     */
    function __construct(\ReflectionMethod $reflectionMethod, \Hirudo\Core\Module $owner) {
        $this->dependenciesManager = ModulesContext::instance()->getDependenciesManager();
        $this->reflectionMethod = $reflectionMethod;
        $this->module = $owner;
        
        foreach ($this->reflectionMethod->getParameters() as /* @var $parameter \ReflectionParameter */ $parameter) {
            $this->paramValues[$parameter->name] = $parameter->isOptional() ? $parameter->getDefaultValue() : null;
            $this->params[] = $parameter;
        }
    }

    /**
     * Gets the method name.
     * 
     * @return string 
     */
    public function getName() {
        return $this->reflectionMethod->name;
    }

    /**
     * Gets the method's parameters.
     * 
     * @return array<\ReflectionParameter> 
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * Sets the value of a method's param.
     * 
     * @param string $paramName The parameter name.
     * @param mixed $value The value for the parameter.
     */
    public function setParamValue($paramName, $value) {
        $this->paramValues[$paramName] = $value;
    }

    /**
     * Gets the value of a method's param.
     * 
     * @param string $paramName
     * @return type 
     */
    public function getParamValue($paramName) {
        return $this->paramValues[$paramName];
    }

    /**
     * Executes the task.
     */
    public function invoke() {
        return $this->reflectionMethod->invokeArgs($this->module, $this->paramValues);
    }

    /**
     * Gets the method's meta data.
     * 
     * @return array<mixed> An annotations list. 
     */
    public function getTaskAnnotations() {
        return $this->dependenciesManager->getMethodMetadata($this->reflectionMethod);
    }

    /**
     * Gets a single annotation from the merhod.
     * 
     * @param string $annotationName The fully qualified annotation class or annotation id.
     * @return mixed The annotation 
     */
    public function getTaskAnnotation($annotationName) {
        return $this->dependenciesManager->getMethodMetadataById($this->reflectionMethod, $annotationName);
    }

    /**
     * Gets the module that owns the method to be executed.
     * 
     * @return Module
     */
    public function getModule() {
        return $this->module;
    }

}

?>
