<?php

require_once 'persistence/SAQuery.php';

/**
 * Description of JAWQueryFactory
 *
 * @author JeyDotC
 * 
 * Hirudo\Core\Annotations\Export QueryFactories
 */
class SAQueryFactory extends QueryFactory {

    protected function createQuery() {
        return new SAQuery();
    }

}

?>
