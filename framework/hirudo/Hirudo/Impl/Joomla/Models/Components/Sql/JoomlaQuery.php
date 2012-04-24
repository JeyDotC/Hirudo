<?php

/**
 * «Copyright 2012 Jeysson José Guevara Mendivil(JeyDotC)» 
 * 
 * This file is part of Hirudo.
 * 
 * Hirudo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Hirudo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Impl\Joomla\Models\Components\Sql;

use Hirudo\Models\Components\Sql\Query;

/**
 * Description of SAQuery
 *
 * @author JeyDotC
 */
class JoomlaQuery extends Query {

    /**
     *
     * @var JDatabase
     */
    private $dbo;

    function __construct() {
        $this->dbo = JFactory::getDBO();
    }

    protected function executeWrite($query) {
        $this->dbo->setQuery($query);
        $result = $this->dbo->query();
        if ($result === FALSE) {
            throw new Exception("Database Error: [{$this->dbo->getErrorNum()}: {$this->dbo->getErrorMsg()}]");
        }
        return $result;
    }

    protected function compileInsert($table, array $keys, array $values) {
        $query = "INSERT INTO $table (" . implode(', ', $keys) . ") VALUES (" . implode(', ', $values) . ")";
        return $query;
    }

    protected function compileUpdate($table, array $values, array $orderby,
            array $where) {
        foreach ($values as $key => $val) {
            $setPartStrings[] = $key . " = " . $val;
        }

        $setPart = implode(', ', $setPartStrings);
        $orderbyPart = (count($orderby) >= 1) ? ' ORDER BY ' . implode(", ", $orderby) : '';
        $wherePart = (count($where) >= 1) ? " WHERE " . implode(" ", $where) : '';

        $sql = "UPDATE $table 
                SET $setPart 
                 $wherePart 
                 $orderbyPart";

        return $sql;
    }

    protected function compileDelete($table, array $where) {

        $wherePart = (count($where) >= 1) ? " WHERE " . implode(" ", $where) : '';

        return "DELETE FROM $table
                $wherePart";
    }

    protected function executeSelect($query, $limit, $offset) {
        $this->dbo->setQuery($query, $offset, $limit);
        return new JoomlaResult($this->dbo);
    }

}

?>
