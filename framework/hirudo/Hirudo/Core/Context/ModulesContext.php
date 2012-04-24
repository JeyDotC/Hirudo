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

use Hirudo\Core\Context\ModuleCall,
    Hirudo\Core\Context\Principal,
    Hirudo\Core\Context\Session,
    Hirudo\Core\Context\Request,
    Hirudo\Core\Context\AppConfig,
    Hirudo\Core\Context\Routing;
use Hirudo\Core\Annotations\Import;
use Hirudo\Core\DependencyInjection\AnnotationLoader;

/**
 * Description of ModulesContext
 *
 * @author Virtualidad
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
    private $dependenciesManager;

    /**
     *
     * @var ModuleCall
     */
    private $currentCall;

    /**
     *
     * @return ModuleCall
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
     *
     * @return Principal
     */
    public function getCurrentUser() {
        return $this->user;
    }

    /**
     *
     * @return Session
     */
    public function &getSession() {
        return $this->session;
    }

    /**
     *
     * @param Session $session
     * @Import(id="session")
     */
    public function setSession(Session $session) {
        $this->session = $session;
    }

    /**
     *
     * @param Request $request 
     * @Import(id="request")
     */
    public function setRequest(Request $request) {
        $this->request = $request;
    }

    /**
     *
     * @return Request
     */
    public function &getRequest() {
        return $this->request;
    }

    /**
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
     *
     * @return AnnotationLoader
     */
    public function getDependenciesManager() {
        return $this->dependenciesManager;
    }

    public function setDependenciesManager(AnnotationLoader $dependenciesManager) {
        $this->dependenciesManager = $dependenciesManager;
    }

}