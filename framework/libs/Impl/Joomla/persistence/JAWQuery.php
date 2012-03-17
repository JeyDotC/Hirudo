<?php

require_once 'JAWResult.php';

/**
 * Description of JAWQuery
 *
 * @author JeyDotC
 */
class JAWQuery extends Query {

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
        return new JAWResult($this->dbo);
    }

}

?>
