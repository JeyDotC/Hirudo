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