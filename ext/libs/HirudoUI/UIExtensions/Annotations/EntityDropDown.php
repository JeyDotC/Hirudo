<?php

namespace UIExtensions\Annotations;

use Hirudo\Core\Context\ModulesContext;
use UIExtensions\Annotations\UIHint;

/**
 * Designates a dropdown that takes its values from the call to a method of a 
 * class. Such method should return a list of objects (known as entities) from
 * which the values and the texts will be taken.
 *
 * @author JeyDotC
 * 
 * @Annotation
 */
class EntityDropDown extends DropDown {

    private $entities;

    /**
     * The fully qualified class name of the object that will return the list of
     * entities.
     * 
     * @var string
     */
    public $serviceClass = "";

    /**
     * The name of the method that will return the list of entities.
     * 
     * @var string
     */
    public $method = "findAll";

    /**
     * The name of the field that contains the value for each entity. Usually "id"
     * 
     * @var string
     */
    public $valueField = "id";

    /**
     * The name of the field that contains the text for each entity.
     * 
     * @var string
     */
    public $textField = "";

    /**
     * {@inheritdoc}
     * 
     * @return array
     */
    function values() {
        if (!isset($this->entities)) {
            $class = $this->serviceClass;
            $method = $this->method;

            $service = new $class();
            ModulesContext::instance()->getDependenciesManager()->resolveDependencies($service);
            $values = $service->$method();

            foreach ($values as $value) {
                $vars = get_object_vars($value);
                $this->entities[$this->getValue($value, $vars, $this->valueField)] = $this->getValue($value, $vars, $this->textField);
            }
        }

        return $this->entities;
    }

    private function getValue($object, $vars, $field) {
        if (!array_key_exists($field, $vars)) {
            $getter = "get" . ucfirst($field);
            $value = $object->$getter();
        } else {
            $value = $vars[$field];
        }

        return $value;
    }

}

?>
