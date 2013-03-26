<?php

namespace UIExtensions\Html\Grid;

class GridRowViewData {

    private $item;
    private $isAlternate;

    function __construct($item, $isAlternate) {
        $this->item = $item;
        $this->isAlternate = $isAlternate;
    }

    public function getItem() {
        return $this->item;
    }

    public function getIsAlternate() {
        return $this->isAlternate;
    }

}
?>