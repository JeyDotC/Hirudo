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
 * An entity normilizer. Converts an entity into an array so it can be easily 
 * serialized into any text format.
 */
class EntityToArrayConverter {

    /**
     * Converts the given entity into an array.
     * 
     * @param mixed $entity The entity to be converted.
     * @return array The array that represents the entity. 
     */
    public function convert($entity, $ignoreUnsetValues = false) {
        //If it's not an entity, there's no reason to convert it.
        if (is_string($entity) || is_scalar($entity) || is_null($entity)) {
            return $entity;
        }

        $result = array();

        if (is_array($entity)) {
            foreach ($entity as $object) {
                $result[] = $this->convert($object);
            }
            return $result;
        }

        $reflection = new \ReflectionClass($entity);
        foreach ($reflection->getProperties() as /* @var $property \ReflectionProperty */$property) {
            if (!$property->isStatic()) {
                $accesible = $property->isPublic();
                if (!$accesible) {
                    $property->setAccessible(true);
                }
                $value = $property->getValue($entity);

                if (!$ignoreUnsetValues || ($ignoreUnsetValues && !is_null($value))) {
                    $result[$property->name] = $this->convert($value);
                }
            }
        }

        return $result;
    }

}

?>