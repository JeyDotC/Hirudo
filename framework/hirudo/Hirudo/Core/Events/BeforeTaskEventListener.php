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
 * Description of BeforeTaskEventListener
 *
 * @author JeyDotC
 */
abstract class BeforeTaskEventListener implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        return array(BeforeTaskEvent::NAME => "onBeforeTask");
    }

    //A wrapper function for future cool stuff.
    public function onBeforeTask(BeforeTaskEvent $e) {
        $annotations = \Hirudo\Core\Context\ModulesContext::instance()->getDependenciesManager()->getClassMetadata(new \ReflectionClass($this));
        $isCallable = true;

        if (is_array($annotations)) {
            foreach ($annotations as $annotation) {
                if ($annotation instanceof Annotations\ForCall) {
                    $isCallable = $this->isCallable($annotation);
                    break;
                }
            }
        }

        if ($isCallable) {
            $this->beforeTask($e);
        }
    }

    private function isCallable(Annotations\ForCall $forCall) {
        $call = \Hirudo\Core\Context\ModulesContext::instance()->getCurrentCall();
        
        if(!empty($forCall->app) && $forCall->app != $call->getApp()){
            return false;
        }
        
        if(!empty($forCall->module) && $forCall->module != $call->getModule()){
            return false;
        }
        
        if(!empty($forCall->task) && $forCall->task != $call->getTask()){
            return false;
        }
        
        return true;
        
    }

    protected abstract function beforeTask(BeforeTaskEvent $e);
}

?>
