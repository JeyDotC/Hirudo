<?php

namespace Hirudo\Impl\StandAlone\Models\Components\Sql;

use Hirudo\Models\Components\Sql\Result;

/**
 * Description of SAResult
 *
 * @author JeyDotC
 */
class SAResult implements Result {

    private $limit;
    private $offset;

    /**
     *
     * @var \PDOStatement
     */
    private $statement;

    function __construct($statement, $offset, $limit) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->statement = $statement;
    }

    public function firstRow() {
        return $this->statement->fetch(\PDO::FETCH_ASSOC);
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
        $results = $this->statement->fetchAll(\PDO::FETCH_ASSOC);
        if ($this->offset !== false) {
            $length = $this->limit !== false ? $this->limit : null;
            $results = array_slice($results, $this->offset, $length);
        }

        return $results;
    }

    public function row($n = 0) {
        if ($n == 0) {
            $row = $this->firstRow();
        } else {
            $list = $this->resultList();
            $row = array();

            if (isset($list[$n])) {
                $row = $list[$n];
            }
        }

        return $row;
    }

    public function rowCount() {
        return $this->statement->rowCount();
    }

}

?>
