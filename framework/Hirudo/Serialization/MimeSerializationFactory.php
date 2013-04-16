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
 * A default SerializationFactory implementation. This one creates
 * the serializer and the de-serializer based on a mime type.
 * 
 * If the mime given to request the serializer or de-serializer has a slash ('/'),
 * the text before it will be ignored, so if $mimeType is "application/json", only the
 * "json" part of the string will be taken into account.
 */
class MimeSerializationFactory implements SerializationFactory {

    private $serializerIinstances = array();
    private $deserializerIinstances = array();

    public function getMime($mimeType) {
        $slashPos = strrpos($mimeType, "/");
        return ucfirst(strtolower(substr($mimeType, $slashPos + 1)));
    }

    /**
     * Gets a Serializer based on the given mime type.
     * 
     * @param string $mimeType A string with the mime type. 
     * 
     * @return EntitySerializerBase 
     */
    function getSerializer($mimeType = null) {
        $mime = $this->getMime($mimeType);

        if (!isset($this->serializerIinstances[$mime])) {
            $className = "Hirudo\\Serialization\\Impl\\{$mime}\\EntitySerializer" . strtoupper($mime);
            $this->serializerIinstances[$mime] = new $className();
        }

        return $this->serializerIinstances[$mime];
    }

    /**
     * Gets a de-Serializer based on the given mime type.
     * 
     * @param string $mimeType
     * @return EntityDeserializerBase 
     */
    function getDeserializer($mimeType = null) {
        $mime = $this->getMime($mimeType);

        if (!isset($this->deserializerIinstances[$mime])) {
            $className = "Hirudo\\Serialization\\Impl\\{$mime}\\EntityDeserializer" . strtoupper($mime);
            $this->deserializerIinstances[$mime] = new $className();
        }

        return $this->deserializerIinstances[$mime];
    }

}

?>