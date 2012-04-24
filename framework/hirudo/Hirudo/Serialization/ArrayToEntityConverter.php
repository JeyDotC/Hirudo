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
 * Hirudo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Serialization;

use \ReflectionClass;

/**
 * 
 */
class ArrayToEntityConverter {

    private static $knownPrimitiveTypes = array("mixed", "array", "int", "integer", "float", "bool", "boolean", "string");

    public function convert($array, &$objectOrClassName) {
        $objectInstance = null;

        if ($array != null) {
            if ($this->isArrayOfObjects($array)) {
                $objectInstance = $this->convertArray($array, $objectOrClassName);
            } else {
                $objectInstance = $this->convertObject($array, $objectOrClassName);
            }
        }

        return $objectInstance;
    }

    private function isArrayOfObjects(array $array) {
        return !(array_keys($array) !== range(0, count($array) - 1));
    }

    private function convertObject(array $array, &$class) {

        if (is_string($class)) {
            $objectInstance = new $class();
        } else {
            $objectInstance = $class;
        }

        $reflectionClass = new ReflectionClass($objectInstance);

        foreach ($array as $name => $value) {
            if (is_scalar($value)) {
                $this->setValue($reflectionClass, $objectInstance, $name, $value);
            } else {
                $this->dealArrayValue($reflectionClass, $objectInstance, $name, $value);
            }
        }

        return $objectInstance;
    }

    private function convertArray(array $array, $class) {
        $arrayOfInstances = array();

        foreach ($array as $value) {
            $arrayOfInstances[] = $this->convert($value, $class);
        }

        return $arrayOfInstances;
    }

    private function setValue(&$reflectionClass, &$objectInstance, $name, $value) {
        if ($reflectionClass->hasProperty($name)) {
            /* @var $property ReflectionProperty */
            $property = $reflectionClass->getProperty($name);

            if ($property->isPublic()) {
                $objectInstance->{$name} = $value;
            } else {
                $methodName = "set" . ucwords($name);

                if ($reflectionClass->hasMethod($methodName)) {
                    $objectInstance->{$methodName}($value);
                }
            }
        }
    }

    private function dealArrayValue(&$reflectionClass, &$objectInstance, $name,
            &$array) {
        if ($reflectionClass->hasProperty($name)) {
            $property = $reflectionClass->getProperty($name);
            $doc = $property->getDocComment();
            $type = $this->getTypeFromDoc($doc);

            if ($array == null || $this->typeIsPrimitive($type)) {
                $this->setValue($reflectionClass, $objectInstance, $name, $array);
            } else if (class_exists($type)) {
                $resultingObject = $this->convertObject($array, $type);
                $this->setValue($reflectionClass, $objectInstance, $name, $resultingObject);
            } else if (strpos($type, "array<") === 0) {
                $className = str_replace(array("array<", ">", " "), "", $type);
                $arrayOfObjects = $this->convertArray($array, $className);
                $this->setValue($reflectionClass, $objectInstance, $name, $arrayOfObjects);
            }
        }
    }

    private function typeIsPrimitive($type) {
        return in_array(strtolower($type), self::$knownPrimitiveTypes);
    }

    private function getTypeFromDoc($docString) {
        $commentLines = explode("\n", $docString);
        $type = "mixed";

        foreach ($commentLines as $commentLine) {
            if (strpos($commentLine, '@var ') !== false) {
                $type = explode(" ", trim($commentLine));
                $type = trim($type[2]);
                break;
            }
        }

        return $type;
    }

}

?>