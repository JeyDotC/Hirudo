<?php

namespace SampleApp\Models\Components;

use SampleApp\Models\Entities\ComplexObject;
use Hirudo\Core\Context\ModulesContext as ModulesContext;

/**
 * Description of ComplexObjectComponent
 *
 * @author JeyDotC
 */
class ComplexObjectComponent {

    public function save(ComplexObject $complexObject) {
        ModulesContext::instance()->getSession()->put($complexObject->getName(), serialize($complexObject));
    }

    public function get($name) {
        return unserialize(ModulesContext::instance()->getSession()->get($name));
    }

}

?>
