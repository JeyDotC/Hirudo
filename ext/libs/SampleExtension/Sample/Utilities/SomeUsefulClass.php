<?php

namespace Sample\Utilities;

use Hirudo\Core\Annotations\Export;

/**
 * Description of SomeUsefulClass
 *
 * @author JeyDotC
 * @Export(id="service_id1")
 */
class SomeUsefulClass {

    public function foo() {
        return "A useful foo!";
    }

}

?>
