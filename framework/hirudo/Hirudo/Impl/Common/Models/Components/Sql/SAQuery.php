<?php

namespace Hirudo\Impl\Common\Models\Components\Sql;

use Hirudo\Models\Components\Sql\Query;

/**
 * Description of SAQuery
 *
 * @author JeyDotC
 */
class SAQuery extends Query {

    /**
     *
     * @var \PDO
     */
    private $dbo;

    function __construct($dsn, $username, $password, $options = array()) {
        $this->dbo = new \PDO($dsn, $username, $password, $options = array());
    }

    protected function executeWrite($query) {
        return $this->dbo->query($query);
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
        $statement = $this->dbo->query($query);
        return new SAResult($statement, $limit, $offset);
    }

}

?>
