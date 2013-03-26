<?php

namespace UIExtensions\Html\Grid;

/**
 * Defines a grid model
 * 
 * Original: http://mvccontrib.codeplex.com/SourceControl/changeset/view/93c3fbd0f8cc#src/MVCContrib/UI/Grid/GridModel.cs
 * 
 * @author JeyDotC
 */
class GridModel {

    private $columnBuilder;
    /**
     *
     * @var GridSections
     */
    private $sections;
    private $renderer;
    private $emptyText;
    private $attributes = array();

    /**
     * Creates a new grid model.
     * 
     * Avoid overriding this constructor, override the init method instead.
     */
    public function __construct() {
        $this->sections = new GridSections();
        $this->renderer = new HtmlTableGridRenderer();
        $this->emptyText = "There is no data available.";
        $this->columnBuilder = $this->createColumnBuilder();
        $this->init();
    }
    
    /**
     * This function is called after this object is initialized, override it to
     * define your columns. You may also return $this in order to have an extensible
     * fluent interface.
     * 
     * @return void
     */
    protected function init() {
        //Example usage of this method implementation.
        $this->column()->createFor(function($value){
            return (string)$value;
        })->named("Values");
    }

    /**
     * Gets this object's column builder.
     * 
     * @return ColumnBuilder
     */
    public function column() {
        return $this->columnBuilder;
    }
    
    /**
     * Gets the list of columns created for this grid model.
     * 
     * @return array<GridColumn>
     */
    function getColumns() {
        return $this->columnBuilder->getColumns();
    }

    /**
     * 
     * @return GridSections
     */
    public function getSections() {
        return $this->sections;
    }

    /**
     * 
     * @return GridRenderer
     */
    public function getRenderer() {
        return $this->renderer;
    }

    /**
     * Gets the text that is rendered if the data source is empty.
     * 
     * @return string
     */
    public function getEmptyText() {
        return $this->emptyText;
    }

    /**
     * Sets the text that is rendered if the data source is empty.
     * 
     * @param string $emptyText The text to be displayed when the data source is
     * empty.
     * 
     * @return \UIExtensions\Html\Grid\GridModel This
     */
    public function setEmptyText($emptyText) {
        $this->emptyText = $emptyText;
        return $this;
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function setAttributes($attributes) {
        $this->attributes = $attributes;
        return $this;
    }

    public function renderUsing(GridRenderer $renderer) {
        $this->renderer = $renderer;
        return $this;
    }

    protected function createColumnBuilder() {
        return new ColumnBuilder();
    }

}
