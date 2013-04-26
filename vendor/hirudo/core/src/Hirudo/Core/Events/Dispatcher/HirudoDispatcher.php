<?php

namespace Hirudo\Core\Events\Dispatcher;

use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Events\Annotations\Listen;
use Hirudo\Core\Events\Annotations\OverridesListener;
use Hirudo\Core\Events\Annotations\VirtualListener;
use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Description of HirudoDispatcher
 *
 * @author JeyDotC
 */
class HirudoDispatcher extends EventDispatcher {

    /**
     *
     * @var array<ListenerHolder> 
     */
    private $virtualListeners = array();

    /**
     * @see EventDispatcherInterface::addListener
     *
     * @api
     */
    public function addListener($eventName, $listener, $priority = 0) {
        $l = $listener;
        if (!($l instanceof ListenerHolder)) {
            /* @var $l ListenerHolder */
            $l = ListenerHolder::create($listener, $eventName, array());
        }

        if ($l->getIsVirtual()) {
            if (!isset($this->virtualListeners[$l->getVirtualId()])) {
                $this->virtualListeners[$l->getVirtualId()] = "candidate";
            }
            if ($this->virtualListeners[$l->getVirtualId()] == "overridden") {
                return;
            }
        }

        if ($l->getOverrides()) {
            $this->virtualListeners[$l->getOverriddenId()] = "overridden";
        }

        parent::addListener($eventName, $l, $priority);
    }

    public function subscribeObject($object) {
        if ($object instanceof EventSubscriberInterface) {
            $this->addSubscriber($object);
        }
        $reflectedObject = new ReflectionClass($object);
        $listeners = $this->loadObjectListeners($reflectedObject, $object);
        foreach ($listeners as /* @var $listener ListenerHolder */ $listener) {
            $this->addListener($listener->getEventName(), $listener, $listener->getPriority());
        }
    }

    protected function loadObjectListeners(ReflectionClass $reflectedObject, $object) {
        $listeners = array();
        foreach ($reflectedObject->getMethods(ReflectionMethod::IS_PUBLIC) as /* @var $method ReflectionMethod */ $method) {
            $listen = ModulesContext::instance()->getDependenciesManager()->getMethodMetadataById($method, "\Hirudo\Core\Events\Annotations\Listen");
            if ($listen instanceof Listen) {
                $virtual = ModulesContext::instance()->getDependenciesManager()->getMethodMetadataById($method, "\Hirudo\Core\Events\Annotations\VirtualListener");
                $overrides = ModulesContext::instance()->getDependenciesManager()->getMethodMetadataById($method, "\Hirudo\Core\Events\Annotations\OverridesListener");
                $listener = $this->createHolderFromListen(array($object, $method->getName()), $listen, !is_object($object), $virtual, $overrides);
                $listener->setPriority($listen->priority);
                $listeners[] = $listener;
            }
        }

        return $listeners;
    }

    /**
     * @see EventDispatcherInterface::removeListener
     */
    public function removeListener($eventName, $listener) {
        $listenerList = $this->getListeners($eventName);
        if (!count($listenerList)) {
            return;
        }

        $listenerObject = $this->findListener($listener, $listenerList);
        if ($listenerObject !== false) {
            parent::removeListener($eventName, $listenerObject);
        }
    }

    private function findListener($listener, $listeners) {
        foreach ($listeners as $value) {
            if ($value->getListener() == $listener) {
                return $value;
            }
        }

        return false;
    }

    /**
     * Triggers the listeners of an event.
     *
     * This method can be overridden to add functionality that is executed
     * for each listener.
     *
     * @param array[callback] $listeners The event listeners.
     * @param string          $eventName The name of the event to dispatch.
     * @param Event           $event     The event object to pass to the event handlers/listeners.
     */
    protected function doDispatch($listeners, $eventName, Event $event) {
        foreach ($listeners as /* @var $listener ListenerHolder */ $listener) {
            if ($listener->getIsVirtual()
                    && isset($this->virtualListeners[$listener->getVirtualId()])
                    && $this->virtualListeners[$listener->getVirtualId()] == "overridden") {
                continue;
            }
            $listener->run($event);
            if ($event->isPropagationStopped()) {
                break;
            }
        }
    }

    /**
     * 
     * @param Listen $listen
     * @return ListenerHolder A new Listener holder
     */
    private function createHolderFromListen($listener, Listen $listen, $deferred = false, $virtual = null, $overrides = "") {
        $virtualId = "";
        $overridenId = "";

        if ($virtual instanceof VirtualListener) {
            $virtualId = $virtual->id;
        }

        if ($overrides instanceof OverridesListener) {
            $overridenId = $overrides->id;
        }

        return new ListenerHolder($listener, $listen->to, $listen->constraints, $deferred, $virtualId, $overridenId);
    }

}

?>
