<?php

namespace UIExtensions\Html\Grid;

/// <summary>
/// renders a grid as an HTML table.
/// </summary>
class HtmlTableGridRenderer extends GridRenderer {

    private $defaultCssClass = "grid";

    protected function renderHeaderCellEnd() {
        $this->renderText("</th>");
    }

    protected function renderEmptyHeaderCellStart() {
        $this->renderText("<th>");
    }

    protected function renderHeaderCellStart(GridColumn $column) {
        $attributes = $column->getHeaderAttributes();

        $attrs = $this->buildHtmlAttributes($attributes);

        if (strlen($attrs) > 0) {
            $attrs = " $attrs";
        }

        $this->renderText("<th$attrs>");
    }

    protected function renderRowStart(GridRowViewData $rowData) {
        $attributes = $this->gridModel->getSections()->getRow()->getAttributes($rowData);

        if (!array_key_exists("class", $attributes)) {
            $attributes["class"] = $rowData->getIsAlternate() ? "gridrow_alternate" : "gridrow";
        }

        $attributeString = $this->buildHtmlAttributes($attributes);

        if (strlen($attributeString) > 0) {
            $attributeString = " $attributeString";
        }

        $this->renderText("<tr$attributeString>");
    }

    protected function renderRowEnd() {
        $this->renderText("</tr>");
    }

    protected function renderEndCell() {
        $this->renderText("</td>");
    }

    protected function renderStartCell(GridColumn $column, GridRowViewData $rowData) {
        $attrs = $this->buildHtmlAttributes($column->getAttributes($rowData));
        if (strlen($attrs) > 0)
            $attrs = " $attrs";

        $this->renderText("<td$attrs>");
    }

    protected function renderHeadStart() {
        $attributes = $this->buildHtmlAttributes($this->gridModel->getSections()->getHeaderRow()->getAttributes(new GridRowViewData(null, false)));
        if (strlen($attributes) > 0) {
            $attributes = " $attributes";
        }

        $this->renderText("<thead><tr$attributes>");
    }

    protected function renderHeadEnd() {
        $this->renderText("</tr></thead>");
    }

    protected function renderGridStart() {
        if (!array_key_exists("class", $this->gridModel->getAttributes())) {
            $attr = $this->gridModel->getAttributes();
            $attr["class"] = $this->defaultCssClass;
        }

        $attrs = $this->buildHtmlAttributes($this->gridModel->getAttributes());

        if (strlen($attrs) > 0) {
            $attrs = " $attrs";
        }

        $this->renderText("<table$attrs>");
    }

    protected function renderGridEnd($isEmpty) {
        $this->renderText("</table>");
    }

    protected function renderEmpty() {
        $this->renderHeadStart();
        $this->renderEmptyHeaderCellStart();
        $this->renderHeaderCellEnd();
        $this->renderHeadEnd();
        $this->renderBodyStart();
        $this->renderText("<tr><td>{$this->gridModel->getEmptyText()}</td></tr>");
        $this->renderBodyEnd();
    }

    protected function renderBodyStart() {
        $this->renderText("<tbody>");
    }

    protected function renderBodyEnd() {
        $this->renderText("</tbody>");
    }

    /// <summary>
    /// Converts the specified attributes dictionary of key-value pairs into a $of HTML attributes. 
    /// </summary>
    /// <returns></returns>
    protected function buildHtmlAttributes(array $attributes) {
        $attrs = "";
        foreach ($attributes as $key => $value) {
            $attrs .= "$key=\"$value\"";
        }
        return $attrs;
    }

}

?>