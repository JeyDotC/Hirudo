<?php

namespace UIExtensions\Html\Grid;

/**
 * Represents a Grid Row
 */
class GridRow {

    private $attributes;

    function __construct() {
        $this->attributes = function(GridRowViewData $data) {
                    return array();
                };
    }

    /**
     * Returns custom attributes for the row.
     * 
     * @param \UIExtensions\Html\Grid\GridRowViewData $data The data of the row.
     * 
     * @return array An associative array where keys are the names and
     * values are the values of the attributes.
     */
    public function getAttributes(GridRowViewData $data) {
        $attributes = $this->attributes;
        return $attributes($data);
    }

    public function setAttributes(\Closure $attributes) {
        $this->attributes = $attributes;
    }

}

?>