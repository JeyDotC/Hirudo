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

/**
 * Base class for entity de-serializers. 
 */
abstract class EntityDeserializerBase {

    private $arrayToEntityConverter;

    /**
     * Creates a new entity de-serializer. 
     */
    public function __construct() {
        $this->arrayToEntityConverter = new ArrayToEntityConverter();
    }

    /**
     * Converts the given string into an entity of the given class.
     * 
     * @param string $class The class in which the string will be converted.
     * @param string $string The string that will be converted into the given class.
     * 
     * @return mixed An instance of the given class.
     */
    public function deserialize($class, $string) {
        $array = $this->convertStringToArray($string);
        //Add suport for primitive types
        if ($this->arrayToEntityConverter->typeIsPrimitive($class)) {
            return $array;
        }
        
        return $this->arrayToEntityConverter->convert($array, $class);
    }

    /**
     * This is the abstract method to be implemented by any de-serializer, it receives
     * an string to be converted into an associative array which will make easier
     * the conversion into an entity.
     * 
     * @param string $string The associative array that represents the entity.
     * 
     * @return array An associative array that represents the entity.
     */
    protected abstract function convertStringToArray($string);
}

?>