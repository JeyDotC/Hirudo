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

require_once "EntityToArrayConverter.php";

/**
 * A base class for entity serialization.
 */
abstract class EntitySerializerBase {

    private $entityToArrayConverter;

    /**
     * Creates a new entity serializer. 
     */
    public function __construct() {
        $this->entityToArrayConverter = new EntityToArrayConverter();
    }

    /**
     * Serializes an entity into a string.
     * 
     * @param mixed $entity The entity to be serialized.
     * @return string The string representing the entity. 
     */
    public function serialize($entity) {
        $array = $this->entityToArrayConverter->convert($entity);
        return $this->doSerialize($array);
    }

    /**
     * This is the abstract method to be implemented by any serializer, it receives
     * an ssociative array representing the entity making it easier to create the 
     * string representation.
     * 
     * @param array $array The associative array that represents the entity.
     * 
     * @return string The string that represents the entity.
     */
    protected abstract function doSerialize($array);
}

?>