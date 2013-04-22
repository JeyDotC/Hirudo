<?php

namespace UIExtensions\Html\Grid;

/**
 * 
 */
abstract class GridRenderer {

    /**
     *
     * @var GridModel
     */
    protected $gridModel;
    protected $dataSource;
    private $text = "";
    private $visibleColumns;

    /**
     * Renders the given datasource using the given gridModel.
     * 
     * @param \UIExtensions\Html\Grid\GridModel $gridModel The grid model that 
     * defines the table.
     * @param array $dataSource The data to be rendered.
     * 
     * @return string The resulting html table.
     */
    public function render(GridModel $gridModel, $dataSource) {
        $this->gridModel = $gridModel;
        $this->dataSource = $dataSource;

        $this->renderGridStart();
        $hasItems = $this->renderHeader();

        if ($hasItems) {
            $this->renderItems();
        } else {
            $this->renderEmpty();
        }

        $this->renderGridEnd(!$hasItems);
        return $this->text;
    }

    /**
     * Appends the given text to the resulting output.
     * 
     * @param string $text The text to be added to the output.
     */
    protected function renderText($text) {
        $this->text .= $text;
    }

    /**
     * Renders the table's body.
     */
    protected function renderItems() {
        $this->renderBodyStart();

        $isAlternate = false;
        foreach ($this->dataSource as $item) {
            $this->renderItem(new GridRowViewData($item, $isAlternate));
            $isAlternate = !$isAlternate;
        }

        $this->renderBodyEnd();
    }

    /**
     * Renders a row.
     * 
     * @param \UIExtensions\Html\Grid\GridRowViewData $rowData The row to be 
     * rendered.
     */
    protected function renderItem(GridRowViewData $rowData) {
        $this->baseRenderRowStart($rowData);

        foreach ($this->getVisibleColumns() as $column) {
            $this->renderStartCell($column, $rowData);
            $this->renderCellValue($column, $rowData);
            $this->renderEndCell();
        }

        $this->baseRenderRowEnd($rowData);
    }

    /**
     * Renders a cell.
     * 
     * @param \UIExtensions\Html\Grid\GridColumn $column The current column.
     * @param \UIExtensions\Html\Grid\GridRowViewData $rowData The current row.
     */
    protected function renderCellValue(GridColumn $column, GridRowViewData $rowData) {
        $cellValue = $column->getValue($rowData->getItem());

        if ($cellValue != null) {
            $this->renderText((string) $cellValue);
        }
    }

    /**
     * Renders the table's header.
     * 
     * @return boolean true if the header was rendered, false otherwise.
     */
    protected function renderHeader() {
        //No items - do not render a header.
        if (!$this->shouldrenderHeader())
            return false;

        $this->renderHeadStart();

        foreach ($this->getVisibleColumns() as $column) {
            $this->renderHeaderCellStart($column);
            $this->renderHeaderText($column);
            $this->renderHeaderCellEnd();
        }

        $this->renderHeadEnd();

        return true;
    }

    /**
     * Renders a header's text.
     * 
     * @param \UIExtensions\Html\Grid\GridColumn $column The current column.
     */
    protected function renderHeaderText(GridColumn $column) {
        $customHeader = $column->getHeader();

        if ($customHeader != null) {
            $this->renderText($customHeader);
        } else {
            $this->renderText($column->getDisplayName());
        }
    }

    /**
     * Says if whether or not to render the table's header.
     * @return boolean
     */
    protected function shouldrenderHeader() {
        return !$this->isDataSourceEmpty();
    }

    /**
     * Tells if datasource is empty.
     * 
     * @return boolean
     */
    protected function isDataSourceEmpty() {
        return $this->dataSource == null || empty($this->dataSource);
    }

    /**
     * Gets the list of visible columns.
     * 
     * @return array<GridColumn> The columns marked as visible.
     */
    protected function getVisibleColumns() {
        if (!isset($this->visibleColumns)) {
            foreach ($this->gridModel->getColumns() as $column) {
                if ($column->getVisible()) {
                    $this->visibleColumns[] = $column;
                }
            }
        }
        return $this->visibleColumns;
    }

    protected function baseRenderRowStart(GridRowViewData $rowData) {
        $this->renderRowStart($rowData);
    }

    protected function baseRenderRowEnd(GridRowViewData $rowData) {
        $this->renderRowEnd();
    }

    /**
     * Renders the current header cell end. Usually <code></th></code>
     */
    protected abstract function renderHeaderCellEnd();

    /**
     *  Renders the current header cell start. Usually 
     * <code>
     * <th attr1="value1" attr2="value2"... >
     *      Current column title...
     * </code>
     * 
     * @param GridColumn $column The current column.
     */
    protected abstract function renderHeaderCellStart(GridColumn $column);

    /**
     * Renders the current row start. Usually 
     * <code><tr attr1="value1" attr2="value2"... ></code>
     */
    protected abstract function renderRowStart(GridRowViewData $rowData);

    /**
     * Renders the current row end. Usually <code></tr></code>
     */
    protected abstract function renderRowEnd();

    /**
     * Renders the current cell end. Usually <code></td></code>
     */
    protected abstract function renderEndCell();

    /**
     *  Renders the current cell start. Usually 
     * <code>
     * <td attr1="value1" attr2="value2"... >
     *      The value at the current row for the current column...
     * </code>
     * 
     * @param GridColumn $column The current column.
     * @param GridRowViewData $rowViewData The current row.
     */
    protected abstract function renderStartCell(GridColumn $column, GridRowViewData $rowViewData);

    /**
     * Renders the table header start. Usually <code><thead></code>
     */
    protected abstract function renderHeadStart();

    /**
     * Renders the table header end. Usually <code></thead></code>
     */
    protected abstract function renderHeadEnd();

    /**
     * Renders the table start. Usually <code><table></code>
     */
    protected abstract function renderGridStart();

    /**
     * Renders the table header start. Usually <code><thead></code>
     */
    protected abstract function renderGridEnd($isEmpty);

    /**
     * Render the empty text for this table.
     */
    protected abstract function renderEmpty();

    /**
     * Renders the table body start. Usually <code><tbody></code>
     */
    protected abstract function renderBodyStart();

    /**
     * Renders the table body end. Usually <code></tbody></code>
     */
    protected abstract function renderBodyEnd();
}