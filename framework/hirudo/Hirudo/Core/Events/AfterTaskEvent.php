<?php

namespace Hirudo\Core\Events;

use Symfony\Component\EventDispatcher\Event;

/**
 * Description of AfterTaskEvent
 *
 * @author JeyDotC
 */
class AfterTaskEvent extends Event {

    private $taskResult;

    function __construct($result) {
        $this->taskResult = $result;
    }

    public function getTaskResult() {
        return $this->taskResult;
    }

    public function setTaskResult($taskResult) {
        $this->taskResult = $taskResult;
    }

}

?>
