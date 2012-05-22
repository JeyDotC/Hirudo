<?php

namespace Hirudo\Core\Events;

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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Annotations\ForCall;

/**
 * <p>Listens to the BeforeTaskEvent which iccurs before the task is executed and after
 * the task's requirements are satisfied.</p>
 * 
 * <p>The listener only needs to implement the beforeTask method in order to work.</p>
 * 
 * @author JeyDotC
 */
abstract class BeforeTaskEventListener implements EventSubscriberInterface {

    /**
     * Subscribes this event listener to the BeforeTaskEvent.
     * 
     * @return array An array indicating to the event dispatcher which events will
     * it listen to and which method will manage the event.
     */
    public static function getSubscribedEvents() {
        return array(BeforeTaskEvent::NAME => "onBeforeTask");
    }

    /**
     * This is the method that needs to be implemented by the event listener in
     * order to work. This method is invoked before the current task is executed
     * and has the posibility to change the parameters values and to raplace the
     * current call, thus restarting the task call process for the new ModuleCall.
     * 
     * @param BeforeTaskEvent $e The event with the information about the current
     * call.
     * 
     * @see BeforeTaskEvent
     */
    protected abstract function beforeTask(BeforeTaskEvent $e);

    /**
     * A wraper function for the beforeTask method. This method checks the annotations
     * associated to the event listener.
     * 
     * @param BeforeTaskEvent $e 
     * 
     * @see Annotations\ForCall
     */
    public function onBeforeTask(BeforeTaskEvent $e) {
        $annotation = \Hirudo\Core\Context\ModulesContext::instance()->getDependenciesManager()->getClassMetadataById(new \ReflectionClass($this), "Hirudo\Core\Events\Annotations\ForCall");
        $isCallable = true;

        if (!is_null($annotation)) {
            $isCallable = $this->isCallable($annotation);
        }

        if ($isCallable) {
            $this->beforeTask($e);
        }
    }

    private function isCallable(Annotations\ForCall $forCall) {
        $call = \Hirudo\Core\Context\ModulesContext::instance()->getCurrentCall();

        if (!empty($forCall->app) && $forCall->app != $call->getApp()) {
            return false;
        }

        if (!empty($forCall->module) && $forCall->module != $call->getModule()) {
            return false;
        }

        if (!empty($forCall->task) && $forCall->task != $call->getTask()) {
            return false;
        }

        return true;
    }

}

?>
