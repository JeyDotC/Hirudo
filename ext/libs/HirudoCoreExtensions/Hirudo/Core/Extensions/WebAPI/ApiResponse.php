<?php 

namespace Hirudo\Core\Extensions\WebApi; 

use Hirudo\Serialization\MimeSerializationFactory;
use Hirudo\Serialization\SerializationFactory;

/**
 * Serializes an entity based on the Accept header variable.
 *
 * @author JeyDotC
 */
class ApiResponse {
    
    /**
     *
     * @var SerializationFactory
     */
    private $serializationFactory;

    function __construct() {
        $this->serializationFactory = new MimeSerializationFactory();
    }
    
    public function setupHeaders() {
        header("Content-Type: " . Headers::get("Accept"));
    }


    /**
     * Serializes an entity based on the mime type given by the Accept header 
     * variable.
     * 
     * @param mixed $entity
     * @return string
     */
    public function encodeEntity($entity) {
        $responseMime = Headers::get("Accept");
        $serializer = $this->serializationFactory->getSerializer($responseMime);
        return $serializer->serialize($entity);
    }
}

?>
