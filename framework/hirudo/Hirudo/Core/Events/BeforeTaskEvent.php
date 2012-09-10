<?php

namespace Hirudo\Core\Events;

use Hirudo\Core\Context\ModuleCall;
use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Task;
use Symfony\Component\EventDispatcher\Event;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BeforeTaskEvent
 *
 * @author JeyDotC
 */
class BeforeTaskEvent extends Event {

    private $task;
    private $call;
    private $isCallReplaced = false;

    public function __construct(Task $task) {
        $this->task = $task;
        $this->call = ModulesContext::instance()->getCurrentCall();
    }

    public function replaceCall(ModuleCall $call) {
        //Reduce probability of infinite cicles.
        if ($call->getTask() != $this->call->getTask()
                || $call->getModule() != $this->call->getModule()
                || $call->getApp() != $this->call->getApp()) {
            $this->call = $call;
            $this->isCallReplaced = true;
        }
    }

    public function isCallReplaced() {
        return $this->isCallReplaced;
    }

    public function getCall() {
        return $this->call;
    }

    /**
     * 
     * @return Task
     */
    public function getTask() {
        return $this->task;
    }

}

?>
