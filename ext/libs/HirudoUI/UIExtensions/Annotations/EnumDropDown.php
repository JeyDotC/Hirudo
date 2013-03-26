<?php

namespace UIExtensions\Annotations;

/**
 * Designates a dropdown control which takes its values from an {@link \Hirudo\Lang\ArrayEnum}
 * class.
 *
 * @see \Hirudo\Lang\ArrayEnum
 * 
 * @author JeyDotC
 * 
 * @Annotation
 */
class EnumDropDown extends DropDown {

    /**
     * The name of the enum class from which this UIHint will take its values.
     * 
     * @var string
     */
    public $enumClass = "";

    /**
     * {@inheritdoc}
     * 
     * @return array
     */
    public function values() {
        $enumClass = $this->enumClass;
        return $enumClass::values();
    }

}

?>
