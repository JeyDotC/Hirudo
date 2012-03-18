<?php

require_once 'persistence/JAWQuery.php';
/**
 * Description of JAWQueryFactory
 *
 * @author JeyDotC
 * 
 * @export QueryFactories
 */
class JAWQueryFactory extends QueryFactory {
    protected function createQuery() {
        return new JAWQuery();
    }
}

?>
