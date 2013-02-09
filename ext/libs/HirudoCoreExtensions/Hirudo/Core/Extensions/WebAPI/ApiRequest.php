<?php

namespace Hirudo\Core\Extensions\WebApi;

use Hirudo\Serialization\MimeSerializationFactory;

/**
 * Description of ApiRequest
 *
 * @author JeyDotC
 */
class ApiRequest {

    private $serializationFactory;

    function __construct() {
        $this->serializationFactory = new MimeSerializationFactory();
    }

    public function loadEntityFromPayload($className) {
        $mime = Headers::get("Content-Type");

        $deserializer = $this->serializationFactory->getDeserializer($mime);
        $data = file_get_contents('php://input');

        $result = $deserializer->deserialize($className, $data);

        return $result;
    }

}

?>
