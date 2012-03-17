<?php

namespace Hirudo\Core\Annotations;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Description of Export
 *
 * @author JeyDotC
 * 
 * @Annotation
 * @Target({"CLASS", "METHOD", "PROPERTY"})
 */
final class Export {

    /**
     * 
     * @var string 
     */
    public $id = "";

    /**
     *
     * @var string 
     */
    public $factory = "";

}

?>
