<?php

namespace Hirudo\Core\Extensions\Plugins;

use Hirudo\Core\Events\AfterTaskEvent;
use Hirudo\Core\Events\BeforeTaskEvent;
use Hirudo\Core\Extensions\WebApi\ApiResponse;
use \Hirudo\Core\Events\Annotations\Listen;

/**
 * Description of WebApiResponse
 *
 * @author JeyDotC
 */
class WebApiPlugin {

    private $taskIsApi = false;

    /**
     * 
     * 
     * @param BeforeTaskEvent $e
     * 
     * @Listen(to="beforeTask", priority=8)
     */
    function taskIsApi(BeforeTaskEvent $e) {
        $this->taskIsApi = $e->getTask()->getTaskAnnotation("Hirudo\Core\Extensions\WebApi\Annotations\Api") != null;
    }

    /**
     * 
     * 
     * @param AfterTaskEvent $e
     * 
     * @Listen(to="afterTask", priority=8)
     */
    function encodeOutput(AfterTaskEvent $e) {
        if (!$this->taskIsApi) {
            return;
        }
        $result = $e->getTaskResult();
        $apiResponse = new ApiResponse();
        $apiResponse->setupHeaders();
        $e->replaceTaskResult($apiResponse->encodeEntity($result));
    }

}

?>
