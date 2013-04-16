<?php

namespace Hirudo\Core\Events\Annotations;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Description of Virtual
 *
 * @author JeyDotC
 * @Annotation
 * @Target("METHOD")
 */
class OverridesListener {

    /**
     *
     * @var string 
     */
    public $id;
}

?>
