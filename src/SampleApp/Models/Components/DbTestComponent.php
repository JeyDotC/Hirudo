<?php

namespace SampleApp\Models\Components;

use Hirudo\Models\Components\Sql\SimpleSqlComponent;

/**
 * Description of DbTestComponent
 *
 * @author JeyDotC
 */
class DbTestComponent extends SimpleSqlComponent {

    public function getAll() {
        return $this->getQuery()
                        ->select()
                        ->from(array("people"))
                        ->get()
                        ->resultList();
    }

    public function add($name) {
        $this->getQuery()->insertInto("people")
                ->set("name", $name)
                ->commit();
    }

}

?>
