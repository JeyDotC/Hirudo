<?php

namespace UIExtensions\Annotations;

/**
 * This annotation allows to override the default display/editor template which
 * is given by the var annotation of the property.
 * 
 * @author JeyDotC
 * @Annotation
 */
class UIHint {
    
    /**
     * The template name that overrides the default display/editor template
     * 
     * @var string
     */
    public $template = "mixed";
}

?>
