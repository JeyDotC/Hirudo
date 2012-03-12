<?php

namespace Hirudo\Libs\Serialization;

/**
 */
class EntityToArrayConverter {

    private $propertiesArePublic = false;
    private $getPrefix = "get";

    public function __construct($propertiesArePublic = false) {
        $this->propertiesArePublic = $propertiesArePublic;
    }

    /**
     * @return array 
     */
    public function convert($entity) {
        $result = array();

        if (is_array($entity)) {
            foreach ($entity as $object) {
                $result[] = $this->getProperties($object);
            }
            return $result;
        }


        if (!$this->propertiesArePublic) {
            $reflectedObject = new ReflectionClass($entity);
            foreach ($reflectedObject->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {

                if (stripos($method->name, $this->getPrefix) === 0) {
                    $propertyValue = $method->invoke($entity);
                    $index = lcfirst(str_replace($this->getPrefix, "", $method->name));

                    if (!is_object($propertyValue) && !is_array($propertyValue)) {
                        $result[$index] = $propertyValue;
                    } else {
                        $result[$index] = $this->getProperties($propertyValue);
                    }
                }
            }
        } else {
            $result = get_object_vars($entity);
        }

        return $result;
    }

}

?>