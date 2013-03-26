<?php

namespace Hirudo\Core\Extensions\Plugins;

use Hirudo\Core\Events\AfterTaskEvent;
use Hirudo\Core\Events\BeforeTaskEvent;
use Hirudo\Core\Extensions\WebApi\ApiResponse;
use \Hirudo\Core\Events\Annotations\Listen;

/**
 * Allows tasks to be defined as REST-like api methods.
 *
 * @author JeyDotC
 */
class WebApiPlugin {

    private $taskIsApi = false;

    /**
     * Checks if the task to be executed is intended to be a REST-like method.
     * 
     * @param BeforeTaskEvent $e Information about the task to be executed.
     * 
     * @Listen(to="beforeTask", priority=8)
     */
    function taskIsApi(BeforeTaskEvent $e) {
        $this->taskIsApi = $e->getTask()->getTaskAnnotation("Hirudo\Core\Extensions\WebApi\Annotations\Api") != null;
    }

    /**
     * If the previously executed method is an API method, the result of it
     * will be encoded to the format requested by the request headers in the
     * <code>Accept:</code> parametter.
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
