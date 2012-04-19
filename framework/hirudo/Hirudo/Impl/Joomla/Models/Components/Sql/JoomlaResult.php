<?php

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
