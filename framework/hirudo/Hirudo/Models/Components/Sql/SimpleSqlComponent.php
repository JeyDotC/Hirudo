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
