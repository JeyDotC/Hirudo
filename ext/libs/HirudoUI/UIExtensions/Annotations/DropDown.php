<?php

namespace UIExtensions\Annotations;

use Hirudo\Core\Context\ModulesContext;
use UIExtensions\Annotations\UIHint;

/**
 * This UIHint indicates that the property must be rendered as a dropdown
 * control. Usually a <code>select</code> element. But based on other data it
 * may be represented as a list of <code>radios</code> or <code>checkboxes</code>
 *
 * @author JeyDotC
 * 
 * @Annotation
 */
abstract class DropDown extends UIHint implements \ArrayAccess {

    /**
     * The template for this UIHint.
     * 
     * @var string
     */
    public $template = "dropDown";

    /**
     * Tell if multiple values are permitted. This may be represented as a select
     * control with attribute "multiple" set or a list of checkboxes.
     * 
     * @var boolean
     */
    public $allowMultiple = false;

    /**
     * The widget to represent this dropdown. This attribute is to give some 
     * flexibility on how dropdowns are represented.
     * 
     * @var string
     */
    public $widget = "select";

    /**
     * This method returns the values from where the user can choose represented
     * as an array of key/value pairs where keys are the selectable values and 
     * the values the text for the options.
     * 
     * @return array An associative array where keys are the values and the 
     * values of are the text of the options.
     */
    abstract function values();

    public function offsetUnset($offset) {
        throw new \LogicException("This is a read-only collection");
    }

    public function offsetSet($offset, $value) {
        throw new \LogicException("This is a read-only collection");
    }

    public function offsetExists($offset) {
        $values = $this->values();
        return array_key_exists($offset, $values);
    }

    public function offsetGet($offset) {
        $values = $this->values();
        return $values[$offset];
    }

}

?>
