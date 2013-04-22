<?php

namespace UIExtensions\Html\Grid;

use Closure;

/**
 * A calendar grid renderer, this implementation creates a table
 * which renders the elements of a single month in their corresponding days, with
 * an outlook-like layout.
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

    /**
     * Creates a new calendar renderer for the given month at the given year.
     * 
     * @param int $year The year for which this calendar will be rendered.
     * @param int $month The month of the year for which this calendar will be rendered. 
     * @param Closure<mixed, DateTime> $dateRequester The function in charge of requesting
     * the date for each value.
     */
    function __construct($year, $month, Closure $dateRequester) {
        $this->year = $year;
        $this->month = $month;
        $this->dateRequester = $dateRequester;
    }

    /**
     * {@inheritdoc}
     */
    public function render(GridModel $gridModel, $dataSource) {
        $monthGridModel = new MonthGridModel($gridModel);
        $monthDataSource = new MonthDataSource($this->year, $this->month, $dataSource, $this->dateRequester);
        return parent::render($monthGridModel, $monthDataSource);
    }

}

?>
