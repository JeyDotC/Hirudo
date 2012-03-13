<?php

namespace Hirudo\Libs\Serialization;

require_once "ArrayToEntityConverter.php";

abstract class EntityDeserializerBase {

    private $arrayToEntityConverter;

    public function __construct() {
        $this->arrayToEntityConverter = new ArrayToEntityConverter();
    }

    /**
     *
     * @param string $class
     * @param string $string
     * @return mixed 
     */
    public function deserialize($class, $string) {
        $array = $this->convertStringToArray($string);
        return $this->arrayToEntityConverter->convert($array, $class);
    }

    protected abstract function convertStringToArray($string);
}

?>