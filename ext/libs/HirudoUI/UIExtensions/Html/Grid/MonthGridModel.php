<?php

namespace UIExtensions\Html\Grid;

use UIExtensions\Html\Grid\GridModel;

/**
 * Description of MonthGridModel
 *
 * @author JeyDotC
 */
class MonthGridModel extends GridModel {

    private static $weekDays = array(
        "Sunday",
        "Monday",
        "Tuesday",
        "Wendesday",
        "Thursday",
        "Friday",
        "Saturday");

    /**
     * The original Grid model
     * 
     * @var GridModel
     */
    private $gridModel;

    function __construct(GridModel $gridModel, array $weekDays = array()) {
        if(count($weekDays) == 7){
            self::$weekDays = $weekDays;
        }
        $this->gridModel = $gridModel;
        parent::__construct();
    }

    protected function init() {
        $gridModel = $this->gridModel;
        foreach (self::$weekDays as $dayOfWeek => $day) {
            $this->column()->createFor(function (array $current) use($gridModel, $dayOfWeek) {
                        $day = $current[$dayOfWeek];
                        $result = "
                            <div class='day'>{$day->getDay()}</div>
                                <div>";

                        foreach ($day->getData() as $value) {
                            foreach ($gridModel->getColumns() as $column) {
                                $result .= "<div>{$column->getValue($value)}</div>";
                            }
                        }
                        $result .= "</div>";

                        return $result;
                    })->cellCondition(function (array $current)use($dayOfWeek) {
                        if (!isset($current[$dayOfWeek])) {
                            return false;
                        }
                        $day = $current[$dayOfWeek];
                        return $day->getDay() != 0;
                    })->named($day);
        }
    }

}

?>
