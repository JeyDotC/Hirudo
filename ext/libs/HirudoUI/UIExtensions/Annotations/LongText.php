<?php

namespace UIExtensions\Annotations;

/**
 * Marks a field to be represented as a long text field. Usually a <code>textarea</code>
 *
 * @author JeyDotC
 * @Annotation
 */
class LongText extends UIHint {

    /**
     * 
     * @var string
     */
    public $template = "longText";

}

?>
