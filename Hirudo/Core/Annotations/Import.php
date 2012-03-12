<?php

namespace Hirudo\Core\Annotations;

/**
 * Description of Import
 *
 * @author JeyDotC
 * @Annotation
 * @Target("METHOD", "PROPERTY")
 */
class Import {

    /**
     *
     * @var string 
     */
    public $serviceId = "";
}

?>
