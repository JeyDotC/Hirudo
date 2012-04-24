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
 */
class EntityToArrayConverter {

    private $propertiesArePublic = false;
    private $getPrefix = "get";

    public function __construct($propertiesArePublic = false) {
        $this->propertiesArePublic = $propertiesArePublic;
    }

    /**
     * @return array 
     */
    public function convert($entity) {
        $result = array();

        if (is_array($entity)) {
            foreach ($entity as $object) {
                $result[] = $this->getProperties($object);
            }
            return $result;
        }


        if (!$this->propertiesArePublic) {
            $reflectedObject = new ReflectionClass($entity);
            foreach ($reflectedObject->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {

                if (stripos($method->name, $this->getPrefix) === 0) {
                    $propertyValue = $method->invoke($entity);
                    $index = lcfirst(str_replace($this->getPrefix, "", $method->name));

                    if (!is_object($propertyValue) && !is_array($propertyValue)) {
                        $result[$index] = $propertyValue;
                    } else {
                        $result[$index] = $this->getProperties($propertyValue);
                    }
                }
            }
        } else {
            $result = get_object_vars($entity);
        }

        return $result;
    }

}

?>