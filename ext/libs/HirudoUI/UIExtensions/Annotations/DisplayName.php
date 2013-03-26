<?php

namespace UIExtensions\Annotations;

/**
 * This annotation describes the text to be rendered as the label for the 
 * control. Optionally setting a description.
 *
 * @author JeyDotC
 * @Annotation
 */
class DisplayName {

    /**
     * The name to be displayed as the label.
     * 
     * @var string
     */
    public $name = "";

    /**
     * A description for the control.
     * 
     * @var string
     */
    public $description = "";

    public function __construct(array $values) {
        if (!isset($values['value'])) {
            $values['value'] = null;
        }

        if (is_array($values["value"]) && count($values["value"]) > 1) {
            $this->name = $values['value'][0];
            $this->description = $values['value'][1];
        } else {
            $this->name = $values['value'];
        }
    }

}

?>
