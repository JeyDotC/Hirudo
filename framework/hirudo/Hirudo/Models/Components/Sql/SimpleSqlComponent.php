<?php

namespace Hirudo\Models\Components\Sql;

use Hirudo\Models\Components\ComponentInterface;
use Hirudo\Models\Components\Sql\QueryFactory;
use Hirudo\Models\Components\Sql\Query;
use Hirudo\Core\Annotations\Import;

/**
 * Description of SimpleSqlComponent
 *
 * @author JeyDotC
 */
class SimpleSqlComponent implements ComponentInterface {

    /**
     *
     * @var QueryFactory 
     */
    private $queryFactory;

    /**
     *
     * @param QueryFactory $queryFactory 
     * 
     * @Import(id="query_factory")
     */
    public function setQueryFactory(QueryFactory $queryFactory) {
        $this->queryFactory = $queryFactory;
    }
    
    /**
     *
     * @return Query
     */
    public function getQuery() {
        return $this->queryFactory->getQuery();
    }
}

?>
