<?php

namespace Hirudo\Core\Extensions\WebApi;

use Hirudo\Serialization\MimeSerializationFactory;

/**
 * This class loads an entity from payload based on the class name, the
 * available deserializers and the request content-type.
 *
 * @author JeyDotC
 */
class ApiRequest {

    private $serializationFactory;

    function __construct() {
        $this->serializationFactory = new MimeSerializationFactory();
    }

    /**
     * Creates an instance of the given class name and setup its values by
     * de-serializing the request payload based on the Content-Type given
     * by the header variables.
     * 
     * @param string $className The fully qualified class name to be loaded.
     * @return mixed An instance of the given class.
     */
    public function loadEntityFromPayload($className) {
        $mime = Headers::get("Content-Type");

        $deserializer = $this->serializationFactory->getDeserializer($mime);
        $data = file_get_contents('php://input');

        $result = $deserializer->deserialize($className, $data);

        return $result;
    }

}

?>
