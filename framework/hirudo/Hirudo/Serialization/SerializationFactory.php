<?php

namespace Hirudo\Serialization;

require_once 'EntitySerializerBase.php';
require_once 'EntityDeserializerBase.php';

/**
 * 
 */
interface SerializationFactory {

    /**
     * @return EntitySerializerBase 
     */
    function getSerializer($params = null);

    /**
     * @return EntityDeserializerBase 
     */
    function getDeserializer($params = null);
}

?>