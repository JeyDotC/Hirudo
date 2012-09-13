<?php

namespace Hirudo\Core\Annotations;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Signals a task to accept POST requests only.
 *
 * @Annotation
 * @Target("METHOD")
 */
class HttpPost extends HttpMethod {
    public function __construct() {
        parent::__construct(array("value"=>"POST"));
    }

}

?>
