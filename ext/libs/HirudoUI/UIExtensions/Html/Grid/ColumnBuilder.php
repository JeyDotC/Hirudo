<?php

namespace UIExtensions\Html\Grid;

use Closure;

/**
 * A class to help in the columns creation.
 * 
 * Original: http://mvccontrib.codeplex.com/SourceControl/changeset/view/93c3fbd0f8cc#src/MVCContrib/UI/Grid/ColumnBuilder.cs
 * 
 * @author JeyDotC
 */
class ColumnBuilder {

    private $columns = array();

    /**
     * Creates a new GridColumn object based in the given renderer.
     * 
     * @param Closure $customRenderer A callback which parameter is an element of
     * the model and that must return a string which is normally the value of a property
     * of the received object.
     * 
     * @return \UIExtensions\Html\Grid\GridColumn The created column.
     */
    public function createFor(Closure $customRenderer) {
        $column = new GridColumn($customRenderer, "");
        $column->encode(false);
        $this->columns[] = $column;
        return $column;
    }

    /**
     * Gets all the columns created using this class.
     * 
     * @return array<GridColumn>
     */
    public function getColumns() {
        return $this->columns;
    }

}

?>