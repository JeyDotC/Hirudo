<?php

namespace UIExtensions\Html\Grid;

use Closure;
use ReflectionClass;

/**
 * Column for the grid
 * 
 * Original: http://mvccontrib.codeplex.com/SourceControl/changeset/view/93c3fbd0f8cc#src/MVCContrib/UI/Grid/GridColumn.cs
 * 
 * @author JeyDotC
 */
class GridColumn {

    private $name;
    private $displayName;
    private $columnValueFunc;

    /**
     *
     * @var Closure
     */
    private $cellConditionFunc;
    private $format;
    private $visible = true;
    private $htmlEncode = true;
    private $headerAttributes = array();

    /**
     * array<\Closure>
     */
    private $attributes = array();
    private $headerRenderer;

    /**
     * Creates a new instance of the GridColumn class
     * 
     * @param Closure<mixed, string> $columnValueFunc A function that receives a value from
     * the grid model and returns a string representing a cell value.
     * 
     * @param string $name A name for the column.
     */
    public function __construct(Closure $columnValueFunc, $name) {
        $this->name = $name;
        $this->displayName = $name;
        $this->columnValueFunc = $columnValueFunc;
    }

    public function getName() {
        return $this->name;
    }

    public function getDisplayName() {
        return $this->displayName;
    }

    /**
     * Specifies an explicit name for the column.
     * 
     * @param string $displayName
     * 
     * @return \UIExtensions\Html\Grid\GridColumn This
     */
    public function named($displayName) {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * A custom format to use when building the cell's value
     * 
     * @param string $format Format to use
     * 
     * @return \UIExtensions\Html\Grid\GridColumn This
     */
    public function format($format) {
        $this->format = $format;
        return $this;
    }

    /**
     * Delegate used to hide the contents of the cells in a column.
     * 
     * @param Closure<mixed, boolean> $cellCondition A function that receives 
     * a value from the model and returns a boolean indicating if the value 
     * should be rendered.
     * 
     * @return \UIExtensions\Html\Grid\GridColumn This
     */
    public function cellCondition(Closure $cellCondition) {
        $this->cellConditionFunc = $cellCondition;
        return $this;
    }

    /**
     * Defines additional attributes for the cell.
     * 
     * @param Closure<GridRowViewData, array> $attribute A closure that should 
     * return an array containing the attributes for the cell.
     * 
     * @return \UIExtensions\Html\Grid\GridColumn This
     */
    public function attributes(Closure $attribute) {
        $this->attributes[] = $attribute;
        return $this;
    }

    /**
     * 
     * @param \Closure $headerRenderer
     * @return \UIExtensions\Html\Grid\GridColumn This
     */
    public function header(\Closure $headerRenderer) {
        $this->headerRenderer = $headerRenderer;
        return $this;
    }

    /**
     * Determines whether or not the column should be encoded. Default is true.
     * 
     * @param boolean $houldEncode
     * @return \UIExtensions\Html\Grid\GridColumn This
     */
    public function encode($houldEncode) {
        $this->htmlEncode = $houldEncode;
        return $this;
    }

    
    public function getHeader() {
        if (isset($this->headerRenderer)) {
            $headerRenderer = $this->headerRenderer;
            return $headerRenderer(null);
        }

        return null;
    }

    /**
     * Gets the list of attributes for this row.
     * 
     * @param \UIExtensions\Html\Grid\GridRowViewData $row
     * @return array
     */
    public function getAttributes(GridRowViewData $row) {
        return $this->getAttributesFromRow($row);
    }

    private function getAttributesFromRow(GridRowViewData $row) {
        $dictionary = array();
        foreach ($this->attributes as $attribute) {
            $dictionary = array_merge($dictionary, $attribute($row));
        }

        return $dictionary;
    }

    /**
     * Gets the string representation of the current value.
     * 
     * @param mixed $instance
     * @return string The string representation of the current value at this 
     * column or null if the value doesn't pass the cellCondition.
     */
    public function getValue($instance) {
        $cellConditionFunc = $this->cellConditionFunc;
        if ($cellConditionFunc != null && !$cellConditionFunc($instance)) {
            return null;
        }

        $columnValueFunc = $this->columnValueFunc;
        $value = $columnValueFunc($instance);

        if (!empty($this->format)) { 
            $value = str_replace("{0}", $value, $this->format);
        }

        if ($this->htmlEncode && $value != null) {
            $value = htmlentities($value);
        }

        return $value;
    }

    public function getVisible() {
        return $this->visible;
    }

    public function setVisible($visible) {
        $this->visible = $visible;
        return $this;
    }

    public function getHeaderAttributes() {
        return $this->headerAttributes;
    }

    public function setHeaderAttributes($headerAttributes) {
        $this->headerAttributes = $headerAttributes;
        return $this;
    }
}