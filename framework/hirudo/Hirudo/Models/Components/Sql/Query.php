<?php

namespace Hirudo\Models\Components\Sql;

class QueryWriteMode {
    const NONE = 0;
    const INSERT = 1;
    const UPDATE = 2;
    const DELETE = 3;
    const TRUNCATE = 4;
    const EMPTY_TABLE = 5;
}

class QueryOperator {
    const AND_ = 'AND';
    const OR_ = 'OR';
    const IS = "IS";

    const EQUALS = "=";
    const LIKE = "LIKE";
    const DIFFERENT = "!=";
    const NOT = "NOT";

    const LESS_THAN = "<";
    const LT = "<";
    const LESS_THAN_OR_EQUAL_TO = "<=";
    const LTE = "<=";

    const GREATER_THAN = ">";
    const GT = ">";
    const GREATER_OR_EQUAL = ">=";
    const GTE = ">=";
}

/**
 * Description of JAWQuery
 *
 * @author JeyDotC
 */
abstract class Query {

    private $select = array();
    private $distinct = false;
    private $from = array();
    private $join = array();
    private $where = array();
    private $like = array();
    private $groupby = array();
    private $having = array();
    private $keys = array();
    private $limit = false;
    private $offset = false;
    private $order = false;
    private $orderby = array();
    private $set = array();
    private $whereIn = array();
    private $aliased_tables = array();
    private $storeArray = array();
    private $writeMode = 0;
    // Active Record Caching variables
    private $caching = false;
    private $cacheExists = array();
    private $cache_select = array();
    private $cache_from = array();
    private $cache_join = array();
    private $cacheWhere = array();
    private $cache_like = array();
    private $cache_groupby = array();
    private $cache_having = array();
    private $cache_orderby = array();
    private $cache_set = array();
    private $no_escape = array();
    private $cache_no_escape = array();
    private $compiledQuery = "";

    public function getCompiledQuery() {
        return $this->compiledQuery;
    }

    public function commit() {
        $result = false;
        $table = $this->from[0];

        if ($this->writeMode == QueryWriteMode::INSERT) {

            $keys = array_keys($this->set);
            $values = array_values($this->set);

            $this->compiledQuery = $this->compileInsert($table, $keys, $values);
        } else if ($this->writeMode == QueryWriteMode::UPDATE) {
            
            $this->compiledQuery = $this->compileUpdate($table, $this->set, $this->orderby, $this->where);
        } else if ($this->writeMode == QueryWriteMode::DELETE) {
            
            $this->compiledQuery = $this->compileDelete($table, $this->where);
        }

        $result = $this->executeWrite($this->compiledQuery);
        $this->resetWrite();
        return $result;
    }

    public function countAllResults() {
        return $this->get()->rowCount();
    }

    public function dbPrefix($table) {
        
    }

    function delete($table = "") {
        $this->configureWriteMode($table, QueryWriteMode::DELETE);
        return $this;
    }

    public function distinct() {
        $this->distinct = true;
    }

    public function emptyTable($table = '') {
        $this->configureWriteMode($table, QueryWriteMode::EMPTY_TABLE);
        return $this;
    }

    public function from($from) {
        foreach ((array)$from as $val) {
            $val = trim($val);

            $this->from[] = $val;

            if ($this->caching === true) {
                $this->cache_from[] = $val;
                $this->cacheExists[] = 'from';
            }
        }

        return $this;
    }

    /**
     *
     * @return Result
     */
    public function get() {
        $this->compiledQuery = $this->compileSelect();

        $this->resetSelect();
        return $this->executeSelect($this->compiledQuery, $this->limit, $this->offset);
    }

    public function groupBy($by) {
        
    }

    public function having($key, $value = '', $operator = "=") {
        
    }

    public function orHaving($key, $value = '', $operator = "=") {
        
    }

    public function insertInto($table = '') {
        $this->configureWriteMode($table, QueryWriteMode::INSERT);
        return $this;
    }

    public function join($table, $condition, $type = '') {
        
    }

    public function like($field, $match = '', $side = 'both') {
        
    }

    public function limit($value, $offset = '') {
        
    }

    public function notLike($field, $match = '', $side = 'both') {
        
    }

    public function offset($offset) {
        
    }

    public function orLike($field, $match = '', $side = 'both') {
        
    }

    public function orNotLike($field, $match = '', $side = 'both') {
        
    }

    public function orWhere($key, $value, $operator = " = ") {
        $this->addWhere($key, $value, $operator, QueryOperator::OR_);
        return $this;
    }

    public function orWhereIn($key, array $values) {
        $this->addWhereIn($key, $values, false, QueryOperator::OR_);
        return $this;
    }

    public function orWhereNotIn($key, array $values) {
        $this->addWhereIn($key, $values, true, QueryOperator::OR_);
        return $this;
    }

    public function orderBy($field, $direction = '') {
        
    }

    public function select($fields = "*") {

        foreach ((array)$fields as $val) {
            $val = trim($val);

            if ($val != '') {
                $this->select[] = $val;

                if ($this->caching === true) {
                    $this->cache_select[] = $val;
                    $this->cacheExists[] = 'select';
                }
            }
        }
        return $this;
    }

    public function selectAvg($field = '', $alias = '') {
        
    }

    public function selectMax($field = '', $alias = '') {
        
    }

    public function selectMin($field = '', $alias = '') {
        
    }

    public function selectSum($field = '', $alias = '') {
        
    }

    public function set($key, $value = '') {
        $this->set[$key] = $this->escape($value);
        return $this;
    }

    public function truncate($table = '') {
        $this->configureWriteMode($table, QueryWriteMode::TRUNCATE);
        return $this;
    }

    public function update($table = '') {
        $this->configureWriteMode($table, QueryWriteMode::UPDATE);
        return $this;
    }

    public function where($key, $value, $operator = QueryOperator::EQUALS) {
        $this->addWhere($key, $value, $operator, QueryOperator::AND_);
        return $this;
    }

    public function whereIn($key, array $values) {
        $this->addWhereIn($key, $values);
    }

    public function whereNotIn($key, array $values) {
        $this->addWhereIn($key, $values, true);
    }

    private function configureWriteMode($table, $writeMode) {
        if ($table == '') {
            if (!isset($this->from[0])) {
                throw new InvalidArgumentException("The table argument cannot be empty.");
            }
        } else {
            $this->from[0] = $table;
        }

        $this->writeMode = $writeMode;
    }

    /**
     * "Smart" Escape String
     *
     * Escapes data based on type
     * Sets boolean and null types
     *
     * @param	string
     * @return	mixed
     */
    private function escape($str) {
        if (is_string($str)) {
            $str = "'$str'";
        } elseif (is_bool($str)) {
            $str = ($str === false) ? 0 : 1;
        } elseif (is_null($str)) {
            $str = 'NULL';
        }

        return $str;
    }

    /**
     * Resets the active record values.  Called by the get() function
     *
     * @param	array	An array of fields to reset
     * @return	void
     */
    private function resetItems($resetItems) {
        foreach ($resetItems as $item => $defaultValue) {
            if (!in_array($item, $this->storeArray)) {
                $this->$item = $defaultValue;
            }
        }
    }

    /**
     * Resets the active record values.  Called by the get() function
     *
     * @return	void
     */
    private function resetSelect() {
        $resetItems = array(
            'select' => array(),
            'from' => array(),
            'join' => array(),
            'where' => array(),
            'like' => array(),
            'groupby' => array(),
            'having' => array(),
            'orderby' => array(),
            'wherein' => array(),
            'aliased_tables' => array(),
            'no_escape' => array(),
            'distinct' => false,
            'limit' => false,
            'offset' => false,
            'order' => false,
        );

        $this->resetItems($resetItems);
    }

    /**
     * Resets the active record "write" values.
     *
     * Called by the insert() update() insert_batch() update_batch() and delete() functions
     *
     * @return	void
     */
    private function resetWrite() {
        $resetItems = array(
            'set' => array(),
            'from' => array(),
            'where' => array(),
            'like' => array(),
            'orderby' => array(),
            'keys' => array(),
            'limit' => false,
            'order' => false,
            "writeMode" => QueryWriteMode::NONE,
        );

        $this->resetItems($resetItems);
    }

    private function addWhere($key, $value, $operator, $type) {

        $prefix = (count($this->where) == 0 AND count($this->cacheWhere) == 0) ? '' : $type;

        if (is_null($value)) {
            $operator = QueryOperator::IS;
        }

        $value = ' ' . $this->escape($value);

        $where = "$prefix  $key $operator $value";
        $this->where[] = $where;

        if ($this->caching === true) {
            $this->cacheWhere[] = $where;
            $this->cacheExists[] = 'where';
        }
    }

    private function addWhereIn($key, array $values, $not = false,
            $type = QueryOperator::AND_) {

        $not = ($not) ? QueryOperator::NOT : '';

        foreach ($values as $value) {
            $this->whereIn[] = $this->escape($value);
        }

        $prefix = (count($this->where) == 0) ? '' : $type;

        $whereIn = " $prefix $key $not IN (" . implode(", ", $this->whereIn) . ") ";

        $this->where[] = $whereIn;
        if ($this->caching === true) {
            $this->cacheWhere[] = $whereIn;
            $this->cacheExists[] = 'where';
        }

        // reset the array for multiple calls
        $this->whereIn = array();
    }

    protected abstract function compileInsert($table, array $keys, array $values);

    protected abstract function compileUpdate($table, array $values,
            array $orderby, array $where);

    protected abstract function compileDelete($table, array $where);

    protected abstract function executeWrite($query);

    /**
     *
     * @param type $query
     * @param type $limit
     * @param type $offset 
     * 
     * @return Result
     */
    protected abstract function executeSelect($query, $limit, $offset);

    private function compileSelect() {

        $sql = (!$this->distinct) ? 'SELECT ' : 'SELECT DISTINCT ';

        if (count($this->select) == 0) {
            $sql .= '*';
        } else {
            $sql .= implode(', ', $this->select);
        }

        // ----------------------------------------------------------------
        // Write the "FROM" portion of the query

        if (count($this->from) > 0) {
            $sql .= "\nFROM ";

            $sql .= implode(', ', $this->from);
        }

        // ----------------------------------------------------------------
        // Write the "JOIN" portion of the query

        if (count($this->join) > 0) {
            $sql .= "\n";

            $sql .= implode("\n", $this->join);
        }

        // ----------------------------------------------------------------
        // Write the "WHERE" portion of the query

        if (count($this->where) > 0 OR count($this->like) > 0) {
            $sql .= "\nWHERE ";
        }

        $sql .= implode("\n", $this->where);

        // ----------------------------------------------------------------
        // Write the "LIKE" portion of the query

        if (count($this->like) > 0) {
            if (count($this->where) > 0) {
                $sql .= "\nAND ";
            }

            $sql .= implode("\n", $this->like);
        }

        // ----------------------------------------------------------------
        // Write the "GROUP BY" portion of the query

        if (count($this->groupby) > 0) {
            $sql .= "\nGROUP BY ";

            $sql .= implode(', ', $this->groupby);
        }

        // ----------------------------------------------------------------
        // Write the "HAVING" portion of the query

        if (count($this->having) > 0) {
            $sql .= "\nHAVING ";
            $sql .= implode("\n", $this->having);
        }

        // ----------------------------------------------------------------
        // Write the "ORDER BY" portion of the query

        if (count($this->orderby) > 0) {
            $sql .= "\nORDER BY ";
            $sql .= implode(', ', $this->orderby);

            if ($this->order !== false) {
                $sql .= ($this->order == 'desc') ? ' DESC' : ' ASC';
            }
        }

        return $sql;
    }

}

?>
