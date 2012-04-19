<?php

namespace Hirudo\Impl\Joomla\Models\Components\Sql;

use Hirudo\Models\Components\Sql\QueryFactory;
use Hirudo\Core\Annotations\Export;

/**
 * Description of JAWQueryFactory
 *
 * @author JeyDotC
 * 
 * @Export(id="query_factory")
 */
class JoomlaQueryFactory extends QueryFactory {

    protected function createQuery() {
        return new JoomlaQuery();
    }
}

?>
