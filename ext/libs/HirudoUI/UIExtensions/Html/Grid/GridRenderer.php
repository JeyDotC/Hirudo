<?php

namespace UIExtensions\Html\Grid;

abstract class GridRenderer {

    /**
     *
     * @var GridModel
     */
    protected $gridModel;
    protected $dataSource;
    private $text = "";
    private $visibleColumns;

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

    protected function renderText($text) {
        $this->text .= $text;
    }

    protected function renderItems() {
        $this->renderBodyStart();

        $isAlternate = false;
        foreach ($this->dataSource as $item) {
            $this->renderItem(new GridRowViewData($item, $isAlternate));
            $isAlternate = !$isAlternate;
        }

        $this->renderBodyEnd();
    }

    protected function renderItem(GridRowViewData $rowData) {
        $this->baseRenderRowStart($rowData);

        foreach ($this->getVisibleColumns() as $column) {
            $this->renderStartCell($column, $rowData);
            $this->renderCellValue($column, $rowData);
            $this->renderEndCell();
        }

        $this->baseRenderRowEnd($rowData);
    }

    protected function renderCellValue(GridColumn $column, GridRowViewData $rowData) {
        $cellValue = $column->getValue($rowData->getItem());

        if ($cellValue != null) {
            $this->renderText((string) $cellValue);
        }
    }

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

    protected function renderHeaderText(GridColumn $column) {
        $customHeader = $column->getHeader();

        if ($customHeader != null) {
            $this->renderText($customHeader);
        } else {
            $this->renderText($column->getDisplayName());
        }
    }

    protected function shouldrenderHeader() {
        return !$this->isDataSourceEmpty();
    }

    protected function isDataSourceEmpty() {
        return $this->dataSource == null || empty($this->dataSource);
    }

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

    protected abstract function renderHeaderCellEnd();

    protected abstract function renderHeaderCellStart(GridColumn $column);

    protected abstract function renderRowStart(GridRowViewData $rowData);

    protected abstract function renderRowEnd();

    protected abstract function renderEndCell();

    protected abstract function renderStartCell(GridColumn $column, GridRowViewData $rowViewData);

    protected abstract function renderHeadStart();

    protected abstract function renderHeadEnd();

    protected abstract function renderGridStart();

    protected abstract function renderGridEnd($isEmpty);

    protected abstract function renderEmpty();

    protected abstract function renderBodyStart();

    protected abstract function renderBodyEnd();
}