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

require_once "SerializationFactory.php";

/**
 * A default SerializationFactory implementation 
 */
class MimeSerializationFactory implements SerializationFactory {

    private $serializerIinstances = array();
    private $deserializerIinstances = array();

    public function getMime($mimeType) {
        //Obtiene el sufijo de la implementacion.
        $slashPos = strrpos($mimeType, "/");
        return strtolower(substr($mimeType, $slashPos + 1));
    }

    function getSerializer($mimeType = null) {
        $mime = $this->getMime($mimeType);

        if (!isset($this->serializerIinstances[$mime])) {
            $className = "EntitySerializer" . strtoupper($mime);
            require_once "impl/{$mime}/$className.php";
            $this->serializerIinstances[$mime] = new $className();
        }

        return $this->serializerIinstances[$mime];
    }

    function getDeserializer($mimeType = null) {
        $mime = $this->getMime($mimeType);

        if (!isset($this->deserializerIinstances[$mime])) {
            $className = "EntityDeserializer" . strtoupper($mime);
            require_once "impl/{$mime}/$className.php";
            $this->deserializerIinstances[$mime] = new $className();
        }

        return $this->deserializerIinstances[$mime];
    }

}

?>