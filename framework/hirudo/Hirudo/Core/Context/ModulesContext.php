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

namespace Hirudo\Core\Context;

use Hirudo\Core\Annotations\Import;
use Hirudo\Core\Context\AppConfig;
use Hirudo\Core\Context\Assets;
use Hirudo\Core\Context\ModuleCall;
use Hirudo\Core\Context\Principal;
use Hirudo\Core\Context\Request;
use Hirudo\Core\Context\Routing;
use Hirudo\Core\Context\Session;
use Hirudo\Core\DependencyInjection\DependenciesManager;
use Hirudo\Core\Events\Dispatcher\HirudoDispatcher;
use Hirudo\Core\TemplatingInterface;
use Hirudo\Lang\Loader;

//A quick fix for a weird issue with the autoloader when dealing with annotations.
Loader::using("framework::hirudo::Hirudo::Core::Events::Annotations::*");

/**
 * This class holds the instances of the objects that implements
 * the Hirudo abstract classes.
 *
 * @author JeyDotC
 */
class ModulesContext {

    /**
     *
     * @var ModulesContext 
     */
    private static $instance;
    private $user;
    private $session;
    private $request;
    private $config;
    private $routing;
    private $templating;

    /**
     *
     * @var HirudoDispatcher 
     */
    private $dispatcher;

    /**
     *
     * @var DependenciesManager 
     */
    private $dependenciesManager;
    private $assets;

    /**
     *
     * @var ModuleCall
     */
    private $currentCall;

    /**
     * Gets the ModuleCall that is being executed.
     * 
     * @return ModuleCall The current ModuleCall.
     */
    public function getCurrentCall() {
        return $this->currentCall;
    }

    /**
     *
     * @param ModuleCall $currentCall 
     * 
     */
    public function setCurrentCall(ModuleCall $currentCall) {
        $this->currentCall = $currentCall;
    }

    /**
     * Gets the current ModulesContext instance. Use this method to
     * obtain a ModulesContext object that is actually holding the context 
     * instances.
     * 
     * @return ModulesContext
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new ModulesContext();
        }

        return self::$instance;
    }

    /**
     *
     * @param Principal $user
     * 
     * @Import(id="principal")
     */
    public function setUser(Principal $user) {
        $this->user = $user;
    }

    /**
     * Gets the current user which is stored in session. 
     * 
     * @return Principal
     */
    public function getCurrentUser() {
        return $this->user;
    }

    /**
     * Gets the current session.
     * 
     * @return Session
     */
    public function &getSession() {
        return $this->session;
    }

    /**
     * @param Session $session
     * @Import(id="session")
     */
    public function setSession(Session $session) {
        $this->session = $session;
    }

    /**
     * @param Request $request 
     * @Import(id="request")
     */
    public function setRequest(Request $request) {
        $this->request = $request;
    }

    /**
     * Gets the current request object.
     * 
     * @return Request
     */
    public function &getRequest() {
        return $this->request;
    }

    /**
     * Gets the current configuration object. 
     * 
     * @return AppConfig 
     */
    public function &getConfig() {
        return $this->config;
    }

    /**
     *
     * @param AppConfig $config 
     * @Import(id="config")
     */
    public function setConfig(AppConfig $config) {
        $this->config = $config;
    }

    /**
     * Gets the current implementation of the Routing class.
     * <strong>Note:</strong> The returned object is not bound to any module,
     * so, the action() and moduleAction() methods will return the URL with the
     * Application and Module parts empty. Always use the appAction() method if
     * you are getting the routing object fron this method.
     * 
     * @return Routing 
     */
    public function getRouting() {
        return $this->routing;
    }

    /**
     *
     * @param Routing $routing 
     * @Import(id="routing")
     */
    public function setRouting(Routing $routing) {
        $this->routing = $routing;
    }

    /**
     * Gets the templating system object.
     * 
     * @return TemplatingInterface 
     */
    public function getTemplating() {
        return $this->templating;
    }

    /**
     *
     * @param TemplatingInterface $templating 
     * @Import(id="templating")
     */
    public function setTemplating(TemplatingInterface $templating) {
        $this->templating = $templating;
    }

    /**
     * Gets the current object responsible for the dependency injection.
     * 
     * @return DependenciesManager
     */
    public function getDependenciesManager() {
        return $this->dependenciesManager;
    }

    /**
     * Gets the current assets management system.
     * 
     * @return Assets
     */
    public function getAssets() {
        return $this->assets;
    }

    /**
     *
     * @param Assets $assets 
     * @Import(id="assets")
     */
    public function setAssets(Assets $assets) {
        $this->assets = $assets;
    }

    public function setDependenciesManager(DependenciesManager $dependenciesManager) {
        $this->dependenciesManager = $dependenciesManager;
    }

    public function setDispatcher(HirudoDispatcher $dispatcher) {
        $this->dispatcher = $dispatcher;
    }

    public function getDispatcher() {
        return $this->dispatcher;
    }

}