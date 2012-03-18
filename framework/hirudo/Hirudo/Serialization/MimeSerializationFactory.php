<?php

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