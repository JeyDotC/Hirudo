<?php

namespace Hirudo\Core\Events\Dispatcher;

use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Exceptions\HirudoException;
use Hirudo\Core\Util\ModulesRegistry;
use Symfony\Component\EventDispatcher\Event;

class ListenerHolder {

    private $listener;
    private $eventName;
    private $constraints = array();
    private $isDeferred;
    private $effectiveListener;
    private $isVirtual;
    private $virtualId = "";
    private $overrides = false;
    private $overriddenId = "";
    private $priority;

    public static function create($listener, $eventName, $constraints, $overrides = "") {
        return new ListenerHolder($listener, $eventName, $constraints, false, "", $overrides);
    }

    public static function createVirtual($listener, $eventName, $constraints, $virtualId, $overrides = "") {
        return new ListenerHolder($listener, $eventName, $constraints, false, $virtualId, $overrides);
    }

    public static function createDeferred($listener, $eventName, $constraints, $overrides = "") {
        return new ListenerHolder($listener, $eventName, $constraints, true, "", $overrides);
    }

    public static function createVirtualDeferred($listener, $eventName, $constraints, $virtualId, $overrides = "") {
        return new ListenerHolder($listener, $eventName, $constraints, true, $virtualId, $overrides);
    }

    function __construct($listener, $eventName, $constraints, $isDeferred = false, $virtualId = "", $overrides = "") {
        $this->listener = $listener;
        $this->effectiveListener = $this->listener;
        $this->eventName = $eventName;
        $this->constraints = $constraints;
        $this->isDeferred = $isDeferred;
        $this->isVirtual = !empty($virtualId);
        $this->virtualId = $virtualId;
        $this->overrides = !empty($overrides);
        $this->overriddenId = $overrides;
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

    public function getOverriddenId() {
        return $this->overriddenId;
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
            } else if ($result === false && ModulesContext::instance()->getConfig()->get("enviroment") == "dev") {
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

    public function getPriority() {
        return $this->priority;
    }

    public function setPriority($priority) {
        $this->priority = $priority;
    }

}

?>
