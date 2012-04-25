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

require_once "ArrayToEntityConverter.php";

abstract class EntityDeserializerBase {

    private $arrayToEntityConverter;

    public function __construct() {
        $this->arrayToEntityConverter = new ArrayToEntityConverter();
    }

    /**
     *
     * @param string $class
     * @param string $string
     * @return mixed 
     */
    public function deserialize($class, $string) {
        $array = $this->convertStringToArray($string);
        //Add suport for primitive types
        if ($this->arrayToEntityConverter->typeIsPrimitive($class)) {
            return $array;
        }
        
        return $this->arrayToEntityConverter->convert($array, $class);
    }

    protected abstract function convertStringToArray($string);
}

?>