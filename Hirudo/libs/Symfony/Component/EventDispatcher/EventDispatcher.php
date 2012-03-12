<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\EventDispatcher;

/**
 * The EventDispatcherInterface is the central point of Symfony's event listener system.
 *
 * Listeners are registered on the manager and events are dispatched through the
 * manager.
 *
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Jonathan Wage <jonwage@gmail.com>
 * @author  Roman Borschel <roman@code-factory.org>
 * @author  Bernhard Schussek <bschussek@gmail.com>
 * @author  Fabien Potencier <fabien@symfony.com>
 * @author  Jordi Boggiano <j.boggiano@seld.be>
 *
 * @api
 */
class EventDispatcher implements EventDispatcherInterface {

    private $listeners = array();
    private $sorted = array();

    /**
     * @see EventDispatcherInterface::dispatch
     *
     * @api
     */
    public function dispatch($eventName, Event $event = null) {
        if (!isset($this->listeners[$eventName])) {
            return;
        }

        if (null === $event) {
            $event = new Event();
        }

        $this->doDispatch($this->getListeners($eventName), $eventName, $event);
    }

    /**
     * @see EventDispatcherInterface::getListeners
     */
    public function getListeners($eventName = null) {
        if (null !== $eventName) {
            if (!isset($this->sorted[$eventName])) {
                $this->sortListeners($eventName);
            }

            return $this->sorted[$eventName];
        }

        foreach (array_keys($this->listeners) as $eventName) {
            if (!isset($this->sorted[$eventName])) {
                $this->sortListeners($eventName);
            }
        }

        return $this->sorted;
    }

    /**
     * @see EventDispatcherInterface::hasListeners
     */
    public function hasListeners($eventName = null) {
        return (Boolean) count($this->getListeners($eventName));
    }

    /**
     * @see EventDispatcherInterface::addListener
     *
     * @api
     */
    public function addListener($eventName, $listener, $priority = 0) {
        $this->listeners[$eventName][$priority][] = $listener;
        unset($this->sorted[$eventName]);
    }

    /**
     * @see EventDispatcherInterface::removeListener
     */
    public function removeListener($eventName, $listener) {
        if (!isset($this->listeners[$eventName])) {
            return;
        }

        foreach ($this->listeners[$eventName] as $priority => $listeners) {
            if (false !== ($key = array_search($listener, $listeners))) {
                unset($this->listeners[$eventName][$priority][$key], $this->sorted[$eventName]);
            }
        }
    }

    /**
     * @see EventDispatcherInterface::addSubscriber
     *
     * @api
     */
    public function addSubscriber(EventSubscriberInterface $subscriber) {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $params) {
            if (is_string($params)) {
                $this->addListener($eventName, array($subscriber, $params));
            } else {
                $this->addListener($eventName, array($subscriber, $params[0]), $params[1]);
            }
        }
    }

    /**
     * @see EventDispatcherInterface::removeSubscriber
     */
    public function removeSubscriber(EventSubscriberInterface $subscriber) {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $params) {
            $this->removeListener($eventName, array($subscriber, is_string($params) ? $params : $params[0]));
        }
    }

    /**
     * Triggers the listeners of an event.
     *
     * This method can be overridden to add functionality that is executed
     * for each listener.
     *
     * @param array[callback] $listeners The event listeners.
     * @param string $eventName The name of the event to dispatch.
     * @param Event $event The event object to pass to the event handlers/listeners.
     */
    protected function doDispatch($listeners, $eventName, Event $event) {
        foreach ($listeners as $listener) {
            call_user_func($listener, $event);
            if ($event->isPropagationStopped()) {
                break;
            }
        }
    }

    /**
     * Sorts the internal list of listeners for the given event by priority.
     *
     * @param string $eventName The name of the event.
     */
    private function sortListeners($eventName) {
        $this->sorted[$eventName] = array();

        if (isset($this->listeners[$eventName])) {
            krsort($this->listeners[$eventName]);
            $this->sorted[$eventName] = call_user_func_array('array_merge', $this->listeners[$eventName]);
        }
    }

}
