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
