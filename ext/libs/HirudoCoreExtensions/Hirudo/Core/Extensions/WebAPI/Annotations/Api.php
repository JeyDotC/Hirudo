<?php

namespace Hirudo\Core\Extensions\WebApi\Annotations;

use Hirudo\Core\Extensions\TaskRequirements\Annotations\Resolve;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * This annotation designates a module task to be dealed as a REST-like method.
 * 
 * In such case the parameters will be resolved exclusively by the 
 * Hirudo\Core\Extensions\WebApi\WebApiRequirementResolver resolver. And the
 * returned value (which is spected to be an object) will be serialized to the
 * mime/type given by the Accept header variable of the request header.
 *
 * @author JeyDotC
 * @see \Hirudo\Core\Extensions\WebApi\WebApiRequirementResolver
 * 
 * @Annotation
 * @Target({"METHOD"})
 */
class Api extends Resolve {
    public function __construct() {
        parent::__construct(array("value" => array("__all" => "web_api"),));
    }

}

?>
