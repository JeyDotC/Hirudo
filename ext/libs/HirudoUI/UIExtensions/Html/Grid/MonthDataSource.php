<?php

namespace UIExtensions\Html\Grid;

use Closure;
use DateTime;
use IteratorAggregate;

/**
 * Description of MonthDataSource
 *
 * @author JeyDotC
 */
class MonthDataSource implements IteratorAggregate {

    private $weeks = array();
    private $year;
    private $month;
    private $dataSource;

    /**
     *
     * @var Closure
     */
    private $dateRequester;

    function __construct($year, $month, $dataSource, Closure $dateRequester) {
        $this->year = $year;
        $this->month = $month;
        $this->dataSource = $dataSource;
        $this->dateRequester = $dateRequester;
        $this->setup();
    }

    private function setup() {
        $this->calculateWeeks();
        $dateRequester = $this->dateRequester;
        foreach ($this->dataSource as $value) {
            /* @var $date DateTime */
            $date = $dateRequester($value);
            if ($date instanceof DateTime) {
                $dateData = getdate($date->getTimestamp());
                if ($dateData["mon"] == $this->month) {
                    $this->weeks[(int) ($dateData["mday"] / 7)][$dateData["wday"]]->add($value);
                }
            }
        }
    }

    private function calculateWeeks() {
        $j = 0;
        $timestamp = mktime(0, 0, 0, $this->month, 1, $this->year);
        $maxday = date("t", $timestamp);
        $thismonth = getdate($timestamp);
        $startday = $thismonth['wday'];

        for ($i = 0; $i < ($maxday + $startday); $i++) {
            if (($i % 7) == 0) {
                $this->weeks[$j] = array();
            }

            if ($i < $startday) {
                $this->weeks[$j][] = new Day(0);
            } else {
                $this->weeks[$j][] = new Day($i - $startday + 1);
            }
            if (($i % 7) == 6) {
                $j++;
            }
        }
    }

    public function getIterator() {
        return new \ArrayIterator($this->weeks);
    }

}

?>
