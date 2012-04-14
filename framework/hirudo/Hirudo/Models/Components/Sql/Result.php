<?php

namespace Hirudo\Models\Components\Sql;

/**
 *
 * @author JeyDotC
 */
interface Result {

    function rowCount();

    /**
     * Query result.  "array" version.
     *
     * @return	array
     */
    function resultList();

    /**
     *
     * @param int $n
     * @return array
     */
    function row($n = 0);

    /**
     * Returns the "first" row
     *
     * @return	array
     */
    function firstRow();

    /**
     * Returns the "last" row
     *
     * @return	array
     */
    function lastRow();
}

?>
