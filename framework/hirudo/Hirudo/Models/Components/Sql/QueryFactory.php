<?php

namespace Hirudo\Models\Components\Sql;

/**
 * Description of PersistenceFactory
 *
 * @author JeyDotC
 */
abstract class QueryFactory {

    public function __construct() {
        $this->setQuery($this->createQuery());
    }

    /**
     *
     * @var Query
     */
    private $query;

    /**
     *
     * @return Query
     */
    public function getQuery() {
        return $this->query;
    }

    /**
     * @return Query
     */
    protected abstract function createQuery();

    /**
     *
     * @param Query $query 
     */
    private function setQuery(Query $query) {
        $this->query = $query;
    }

}

?>
