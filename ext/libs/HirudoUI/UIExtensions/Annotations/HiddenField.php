<?php

namespace UIExtensions\Annotations;

/**
 * Marks a field to be represented as a read-only invisible field. Usually an
 * <code>input:hidden</code> field.
 *
 * @author JeyDotC
 * @Annotation
 */
class HiddenField extends UIHint {

    /**
     *
     * @var string
     */
    public $template = "hiddenField";

}

?>
