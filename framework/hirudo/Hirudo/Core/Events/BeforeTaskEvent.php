<?php

namespace Hirudo\Core\Events;

use Symfony\Component\EventDispatcher\Event;
use Hirudo\Core\Context\ModuleCall;
use Hirudo\Core\Task;

/**
 * Description of BedoreTaskEvent
 *
 * @author JeyDotC
 */
class BeforeTaskEvent extends Event {

    const NAME = "beforeTaskEvent";

    /**
     *
     * @var Task
     */
    private $task;

    /**
     *
     * @var ModuleCall 
     */
    private $call;
    private $callReplaced = false;

    function __construct(Task $task, ModuleCall $call) {
        $this->task = $task;
        $this->call = $call;
    }

    public function setParam($name, $value) {
        $this->task->setParamValue($name, $value);
    }

    public function getParam($name) {
        return $this->task->getParamValue($name);
    }

    public function replaceCall(ModuleCall $call) {
        $this->call = $call;
        $this->callReplaced = true;
    }

    public function getCall() {
        return $this->call;
    }

    public function getCallReplaced() {
        return $this->callReplaced;
    }

}

?>
