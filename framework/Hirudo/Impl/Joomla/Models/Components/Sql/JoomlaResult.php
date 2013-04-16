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

use Hirudo\Models\Components\Sql\Result;

/**
 * Description of SAResult
 *
 * @author JeyDotC
 */
class JoomlaResult implements Result {

    private $rowList = null;

    /**
     *
     * @var JDatabase
     */
    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    public function firstRow() {
        return $this->row(0);
    }

    public function lastRow() {
        $result = array();
        $count = $this->rowCount();

        if ($count > 0) {
            $result = $this->row($count - 1);
        }

        return $result;
    }

    public function resultList() {
        if (is_null($this->rowList)) {
            $this->rowList = $this->db->loadAssocList();
        }

        return $this->rowList;
    }

    public function row($n = 0) {
        $list = $this->resultList();
        $row = array();

        if (isset($list[$n])) {
            $row = $list[$n];
        }

        return $row;
    }

    public function rowCount() {
        return $this->db->getNumRows();
    }

}

?>
