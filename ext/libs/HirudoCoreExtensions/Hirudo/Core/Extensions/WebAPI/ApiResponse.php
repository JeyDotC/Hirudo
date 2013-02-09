<?php 

namespace Hirudo\Core\Extensions\WebApi; 

use Hirudo\Serialization\MimeSerializationFactory;
use Hirudo\Serialization\SerializationFactory;

/**
 * Description of ApiResponse
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


    public function encodeEntity($entity) {
        $responseMime = Headers::get("Accept");
        $serializer = $this->serializationFactory->getSerializer($responseMime);
        return $serializer->serialize($entity);
    }
}

?>
