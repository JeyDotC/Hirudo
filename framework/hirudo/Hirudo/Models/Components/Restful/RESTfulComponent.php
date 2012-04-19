<?php

namespace Hirudo\Models\Components\Restful;

use Hirudo\Models\Components\ComponentInterface;
use Hirudo\Serialization\MimeSerializationFactory;

class EmptyResponseException extends Exception {

    public function __construct($url) {
        parent::__construct("[ $url ] Unexpected empty response.");
    }

}

/**
 * 
 * 
 * A basic abstract implementation of a web service request, intended to ease
 * the construction of a web service consumer.
 * 
 * @author JeyDotC
 */
class RESTfulComponent implements ComponentInterface {

    public static $DefaultRoot = "http://";

    /**
     *
     * @var RestRequest
     */
    protected $request;
    protected $serializationFactory;
    private $baseURL;
    private $root = "";
    private $messageFormat = "application/json";
    private $responseFormat = "application/json";

    public function __construct($baseURL, $root = null) {
        $this->root = $root ? $root : self::$DefaultRoot;
        $this->baseURL = $baseURL;
        $this->request = new RestRequest();

        $this->serializationFactory = new MimeSerializationFactory();
    }

    protected function call($url = "/", $verb = "GET", $data = "") {
        $this->request->setUrl("{$this->root}{$this->baseURL}{$url}");
        $this->request->setVerb($verb);
        $this->request->setRequestBody($data);
        $this->request->addHeaderVariable("Content-type", $this->messageFormat);
        $this->request->addHeaderVariable("Accept", $this->responseFormat);

        $this->request->execute();

        return $this->request->getResponseBody();
    }

    /**
     *
     * @return EntitySerializerBase
     */
    protected function getSerializer() {
        return $this->serializationFactory->getSerializer($this->messageFormat);
    }

    /**
     * This is method getDeserializer
     *
     * @return EntityDeserializerBase El objeto que se encargar� de la serializaci�n.
     *
     */
    protected function getDeserializer() {
        return $this->serializationFactory->getDeserializer($this->responseFormat);
    }

    public function addHeaderVariable($key, $value) {
        $this->request->addHeaderVariable($key, $value);
    }

    public function getLastUri() {
        return $this->request->getUrl();
    }

    public function getMessageFormat() {
        return $this->messageFormat;
    }

    public function setMessageFormat($messageFormat) {
        $this->messageFormat = $messageFormat;
    }

    public function getResponseFormat() {
        return $this->responseFormat;
    }

    public function setResponseFormat($responseFormat) {
        $this->responseFormat = $responseFormat;
    }

}

?>