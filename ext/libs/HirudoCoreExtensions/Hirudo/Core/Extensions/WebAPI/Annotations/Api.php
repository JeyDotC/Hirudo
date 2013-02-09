<?php

namespace Hirudo\Core\Extensions\WebApi\Annotations;

use Hirudo\Core\Extensions\TaskRequirements\Annotations\Resolve;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Description of Api
 *
 * @author JeyDotC
 * @Annotation
 * @Target({"METHOD"})
 */
class Api extends Resolve {
    public function __construct() {
        parent::__construct(array("value" => array("__all" => "web_api"),));
    }

}

?>
