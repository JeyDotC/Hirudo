<?php

namespace UIExtensions\Html\Grid;

/**
 * Defines a grid to be rendered.
 * 
 * Original: http://mvccontrib.codeplex.com/SourceControl/changeset/view/93c3fbd0f8cc#src/MVCContrib/UI/Grid/Grid.cs
 * 
 * @author JeyDotC
 */
class Grid {

    /**
     * Data about the grid to be rendered.
     * 
     * @var \UIExtensions\Html\Grid\GridModel
     */
    private $gridModel;
    private $dataSource = array();

    /**
     * Gets the current grid model.
     * 
     * @return GridModel The current grid model.
     */
    public function getGridModel() {
        return $this->gridModel;
    }

    /**
     * Creates a new Grid instance with the given data.
     * 
     * @param mixed $dataSource A collection of data, usually an array but can
     * also be any Traversable object.
     * 
     * @see \Traversable 
     */
    public function __construct($dataSource) {
        $this->dataSource = $dataSource;
        $this->gridModel = new GridModel();
    }

    /**
     * Overrides the default grid renderer with a custom one.
     * 
     * @param \UIExtensions\Html\Grid\GridRenderer $renderer The custom grid renderer
     * 
     * @return \UIExtensions\Html\Grid\Grid This
     * 
     * @see HtmlTableGridRenderer For an example of custom grid renderer.
     */
    public function renderUsing(GridRenderer $renderer) {
        $this->gridModel->renderUsing($renderer);
        return $this;
    }

    /**
     * Sets the text to be displayed when there is no data.
     * 
     * @param string $emptyText The text to be displayed in case of there is no data.
     * 
     * @return \UIExtensions\Html\Grid\Grid This
     */
    public function emptyText($emptyText) {
        $this->gridModel->setEmptyText($emptyText);
        return $this;
    }

    /**
     * Attributes of this grid. Usually the <code>table</code> attributes.
     * 
     * @param array $attributes An array of key value pairs where keys are the 
     * attributes names and the values are the attributes values.
     * 
     * @return \UIExtensions\Html\Grid\Grid This
     */
    public function attributes(array $attributes) {
        $this->gridModel->setAttributes($attributes);
        return $this;
    }

    /**
     * Overrides the current Grid model.
     * 
     * @param \UIExtensions\Html\Grid\GridModel $model The new grid model.
     * 
     * @return \UIExtensions\Html\Grid\Grid This
     */
    public function withModel(GridModel $model) {
        $this->gridModel = $model;
        return $this;
    }

    /**
     * Renders this grid and returns its representation.
     * 
     * @return string
     */
    public function __toString() {
        return $this->toHtmlString();
    }

    /**
     * Renders this grid and returns its representation.
     * 
     * @return string
     */
    public function toHtmlString() {
        return $this->gridModel->getRenderer()->render($this->gridModel, $this->dataSource);
    }

    /**
     * Sets the attributes for the heading row.
     * 
     * @param array $attributes An associative array where keys are the names and
     * values are the values of the attributes.
     * 
     * @return \UIExtensions\Html\Grid\Grid This
     */
    public function headerRowAttributes(array $attributes) {
        $this->gridModel->getSections()->getHeaderRow()->setAttributes(function () use($attributes){
                    return $attributes;
                });
        return $this;
    }

    /**
     * Additional custom attributes for each row
     * 
     * @param \Closure $attributes A function that receives row data 
     * as {@link GridRowViewData} and returns an associative array where keys 
     * are the names and the values are the values of the row attributes.
     * 
     * @return \UIExtensions\Html\Grid\Grid This
     */
    public function rowAttributes(\Closure $attributes) {
        $this->gridModel->getSections()->getRow()->setAttributes($attributes);
        return $this;
    }

}

?>