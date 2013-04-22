<?php

namespace UIExtensions\Html\Grid;

/**
 * Used as viewdata for partials rendered for RowStart/RowEnd
 */
class GridRowViewData {

    private $item;
    private $isAlternate;

    /**
     * Creates a new instance of the GridRowViewData class.
     * 
     * @param mixed $item The current item for this row in the data source.
     * @param boolean $isAlternate Whether this is an alternating row.
     */
    function __construct($item, $isAlternate) {
        $this->item = $item;
        $this->isAlternate = $isAlternate;
    }

    /**
     * Gets the current item of this row.
     * 
     * @return mixed
     */
    public function getItem() {
        return $this->item;
    }

    /**
     * Says if whether this is an alternating row.
     * 
     * @return boolean
     */
    public function getIsAlternate() {
        return $this->isAlternate;
    }

}
?>