<?php

namespace Hirudo\Core\Events;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Description of HirudoEventListenerBase
 *
 * @author JeyDotC
 */
abstract class HirudoEventListenerBase implements EventSubscriberInterface {

    protected static abstract function eventName();
    protected static abstract function methodName();

    public static function getSubscribedEvents() {
        $calledClass = get_called_class();
        return array($calledClass::eventName() => "listen");
    }
    
    /**
     * A wraper function for the beforeTask method. This method checks the annotations
     * associated to the event listener.
     * 
     * @param HirudoEventBase $e 
     * 
     * @see ForCall
     */
    public function listen(HirudoEventBase $e) {
        $annotation = $e->getContext()->getDependenciesManager()->getClassMetadataById(new \ReflectionClass($this), "Hirudo\Core\Events\Annotations\ForCall");
        $isCallable = true;

        if (!is_null($annotation)) {
            $isCallable = $this->isCallable($annotation);
        }

        if ($isCallable) {
            $calledClass = get_called_class();
            $this->{$calledClass::methodName()}($e);
        }
    }

    private function isCallable(ForCall $forCall) {
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
