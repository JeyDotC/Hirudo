<?php

namespace Hirudo\Core\Annotations;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Description of Import
 *
 * @author JeyDotC
 * 
 * @Annotation
 * @Target({"METHOD", "PROPERTY"})
 */
final class Import {

    /**
     *
     * @var string 
     */
    public $id = "";

}

?>
