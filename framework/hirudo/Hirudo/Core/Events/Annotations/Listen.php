<?php

namespace Hirudo\Core\Events\Annotations;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 *  
 * @author JeyDotC
 * 
 * @Annotation
 * @Target("METHOD")
 */
class Listen {
    /**
     *
     * @var string
     */
    public $to;
    /**
     *
     * @var int 
     */
    public $priority = 0;
}

?>
