<?php

/**
 * «Copyright 2012 Jeysson José Guevara Mendivil(JeyDotC)» 
 * 
 * This file is part of Hirudo.
 * 
 * Hirudo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 *  Hirudo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 * 
 *  You should have received a copy of the GNU General Public License
 *  along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Core\Events;

use Symfony\Component\EventDispatcher\Event;
use Hirudo\Core\Context\ModuleCall;
use Hirudo\Core\Task;

/**
 * This event is triggered before a task is executed and after it's requirements
 * are resolved.
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

    /**
     * Creates a new BeforeTaskEvent object.
     * 
     * @param Task $task the task that is about to be executed.
     * @param ModuleCall $call The current ModuleCall
     */
    function __construct(Task $task, ModuleCall $call) {
        $this->task = $task;
        $this->call = $call;
    }

    /**
     * Sets or replaces a task's param value.
     * 
     * @param string $name The name of the parameter.
     * @param mixed $value The new parameter value.
     */
    public function setParam($name, $value) {
        $this->task->setParamValue($name, $value);
    }

    /**
     * Gets a task's parameter value.
     * 
     * @param string $name The task's parameter name
     * 
     * @return mixed The value of the parameter.
     */
    public function getParam($name) {
        return $this->task->getParamValue($name);
    }

    /**
     * Replaces the call to be executed thus restarting the module execution
     * process to work acordingly to the new ModuleCall.
     * 
     * @param ModuleCall $call The new call to be executed.
     */
    public function replaceCall(ModuleCall $call) {
        $this->call = $call;
        $this->callReplaced = true;
    }

    /**
     * Gets the current call.
     * 
     * @return ModuleCall 
     */
    public function getCall() {
        return $this->call;
    }

    /**
     * Says if the call has been replaced. This is true when the
     * replaceCall method has been called.
     * 
     * @return boolean True if the call have been replaced, false otherwise.
     */
    public function getCallReplaced() {
        return $this->callReplaced;
    }

}

?>
