<?php

namespace UIExtensions\Html\Grid;

use Closure;

/**
 * Description of HtmlCalendarTable
 *
 * @author JeyDotC
 */
class HtmlCalendarTableGridRenderer extends HtmlTableGridRenderer {

    private $year;
    private $month;

    /**
     *
     * @var Closure
     */
    private $dateRequester;

    function __construct($year, $month, Closure $dateRequester) {
        $this->year = $year;
        $this->month = $month;
        $this->dateRequester = $dateRequester;
    }

    public function render(GridModel $gridModel, $dataSource) {
        $monthGridModel = new MonthGridModel($gridModel);
        $monthDataSource = new MonthDataSource($this->year, $this->month, $dataSource, $this->dateRequester);
        return parent::render($monthGridModel, $monthDataSource);
    }

}

?>
