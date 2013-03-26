<?php

namespace UIExtensions\Html\Grid;

class GridSections {

    private $row;
    private $headerRow;

    function __construct() {
        $this->row = new GridRow();
        $this->headerRow = new GridRow();
    }

    /**
     * 
     * @return GridRow
     */
    public function getRow() {
        return $this->row;
    }

    /**
     * 
     * @return GridRow
     */
    public function getHeaderRow() {
        return $this->headerRow;
    }

}
?>