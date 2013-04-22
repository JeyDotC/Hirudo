<?php

namespace UIExtensions\Html\Grid;

/**
 * Represents a day in the calendar. It holds all the entities associated to this
 * day.
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

    /**
     * Creates a new day.
     * 
     * @param int $day The day of the month (1-31).
     */
    function __construct($day) {
        $this->day = $day;
    }

    /**
     * Adds an item to this day.
     * 
     * @param mixed $data The item to be added.
     */
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
