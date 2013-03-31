<?php

namespace UIExtensions\Html\Grid;

/**
 * Description of Day
 *
 * @author JeyDotC
 */
class Day {

    /**
     *
     * @var int
     */
    private $day;
    private $data = array();

    function __construct($day) {
        $this->day = $day;
    }

    public function add($data) {
        $this->data[] = $data;
    }

    public function getDay() {
        return $this->day;
    }

    public function getData() {
        return $this->data;
    }

}

?>
