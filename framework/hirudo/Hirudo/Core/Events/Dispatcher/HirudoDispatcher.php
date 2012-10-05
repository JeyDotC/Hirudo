<?php

namespace Hirudo\Core\Events\Dispatcher;

use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Events\Annotations\Listen;
use Hirudo\Core\Exceptions\HirudoException;
use Hirudo\Core\Util\ModulesRegistry;
use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ListenerHolder {

    private $listener;
    private $eventName;
    private $constraints = array();
    private $isDeferred;
    private $effectiveListener;
    private $isVirtual;
    private $virtualId = "";
    private $overrides = "";

    public static function create($listener, $eventName, $constraints, $overrides = "") {
        return new ListenerHolder($listener, $eventName, $constraints, false, false, "", $overrides);
    }

    public static function createVirtual($listener, $eventName, $constraints, $virtualId, $overrides = "") {
        return new ListenerHolder($listener, $eventName, $constraints, false, true, $virtualId, $overrides);
    }

    public static function createDeferred($listener, $eventName, $constraints, $overrides = "") {
        return new ListenerHolder($listener, $eventName, $constraints, true, false, "", $overrides);
    }

    public static function createVirtualDeferred($listener, $eventName, $constraints, $virtualId, $overrides = "") {
        return new ListenerHolder($listener, $eventName, $constraints, true, true, $virtualId, $overrides);
    }
    
    function __construct($listener, $eventName, $constraints, $isDeferred = false, $isVirtual = false, $virtualId = "", $overrides = "") {
        $this->listener = $listener;
        $this->effectiveListener = $this->listener;
        $this->eventName = $eventName;
        $this->constraints = $constraints;
        $this->isDeferred = $isDeferred;
        $this->isVirtual = $isVirtual;
        $this->virtualId = $virtualId;
        $this->overrides = $overrides;
    }

    public function getOverrides() {
        return $this->overrides;
    }

    public function run(Event $event) {
        if ($this->checkConstraints()) {
            $listener = $this->getEffectiveListener();
            call_user_func($listener, $event);
        }
    }

    public function getListener() {
        return $this->listener;
    }

    public function getEventName() {
        return $this->eventName;
    }

    public function getConstraints() {
        return $this->constraints;
    }

    public function getIsDeferred() {
        return $this->isDeferred;
    }

    public function getIsVirtual() {
        return $this->isVirtual;
    }

    public function getVirtualId() {
        return $this->virtualId;
    }

    public function setListener($listener) {
        $this->listener = $listener;
    }

    private function checkConstraints() {
        if (empty($this->constraints)) {
            return true;
        }
        $call = ModulesContext::instance()->getCurrentCall();
        foreach ($this->constraints as $callRegex) {
            $result = preg_match('/^' . $callRegex . '$/', $call);
            if ($result) {
                return true;
            } else if ($result === false && ModulesContext::instance()->getConfig()->get("debug")) {
                throw new HirudoException($call, "One of your event listeners has an error on its constraints: Constraint[/^$callRegex\$/], Event[$this->eventName]");
            }
        }
        return false;
    }

    private function getEffectiveListener() {
        if ($this->isDeferred && !is_object($this->effectiveListener[0])) {
            if (is_subclass_of($this->effectiveListener[0], "Hirudo\Core\Module")) {
                $object = ModulesRegistry::loadModule($this->effectiveListener[0], true);
            } else {
                $object = new $this->effectiveListener[0]();
                ModulesContext::instance()->getDependenciesManager()->resolveDependencies($this->effectiveListener[0]);
            }

            $this->effectiveListener[0] = $object;
        }

        return $this->effectiveListener;
    }

}

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
            $l = ListenerHolder::create($listener, $eventName, array());
        }
        if ($l->getIsVirtual()) {
            if (!isset($this->virtualListeners["{$l->getEventName()}-{$l->getVirtualId()}"])) {
                $this->virtualListeners["{$l->getEventName()}-{$l->getVirtualId()}"] = $l;
            } else {
                return;
            }
        }

        $overrides = $l->getOverrides();
        if (!empty($overrides)) {
            if (isset($this->virtualListeners["{$l->getEventName()}-{$overrides}"])) {
                $overriden = $this->virtualListeners["{$l->getEventName()}-{$overrides}"];
                if ($overriden !== "overriden") {
                    $this->removeListener($l->getEventName(), $overriden);
                    $this->virtualListeners["{$l->getEventName()}-{$overrides}"] = "overriden";
                }
            }
        }

        parent::addListener($eventName, $l, $priority);
    }

    public function subscribeObject($object) {
        if ($object instanceof EventSubscriberInterface) {
            $this->addSubscriber($object);
        }

        $reflectedObject = new ReflectionClass($object);
        foreach ($reflectedObject->getMethods(ReflectionMethod::IS_PUBLIC) as /* @var $method ReflectionMethod */ $method) {
            $listen = ModulesContext::instance()->getDependenciesManager()->getMethodMetadataById($method, "\Hirudo\Core\Events\Annotations\Listen");
            if ($listen instanceof Listen) {
                $listener = $this->createHolderFromListen(array($object, $method->getName()), $listen, !is_object($object));
                $this->addListener($listener->getEventName(), $listener, $listen->priority);
            }
        }
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
            $listener->run($event);
            if ($event->isPropagationStopped()) {
                break;
            }
        }
    }
    
    /**
     * 
     * @param \Hirudo\Core\Events\Annotations\Listen $listen
     * @return ListenerHolder A new Listener holder
     */
    private function createHolderFromListen($listener, Listen $listen, $deferred = false) {
        return new ListenerHolder($listener, $listen->to, $listen->constraints, $deferred, $listen->virtual, $listen->id, $listen->overrides);
    }

}

?>
