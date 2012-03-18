<?php

namespace Hirudo\Serialization;

require_once "EntityToArrayConverter.php";

abstract class EntitySerializerBase {

    private $entityToArrayConverter;

    public function __construct() {
        $this->entityToArrayConverter = new EntityToArrayConverter();
    }

    public function serialize($entity) {
        $array = $this->entityToArrayConverter->convert($entity);
        return $this->doSerialize($array);
    }

    protected abstract function doSerialize($array);
}

?>