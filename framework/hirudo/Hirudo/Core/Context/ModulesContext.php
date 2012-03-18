<?php

namespace Hirudo\Core\Context;

use Hirudo\Core\Context\ModuleCall;
use Hirudo\Core\Context\Principal;
use Hirudo\Core\Context\Session;
use Hirudo\Core\Context\Request;
use Hirudo\Core\Context\AppConfig;
use Hirudo\Core\Context\Routing;
use Hirudo\Core\Annotations\Import;

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
            self::$instance = new DefaultModulesContext();
        }

        return self::$instance;
    }

    /**
     *
     * @param Principal $user
     */
    public function setUser(Principal &$user) {
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
     */
    public function setSession(Session $session) {
        $this->session = $session;
    }

    /**
     *
     * @param Request $request 
     */
    public function setRequest(Request &$request) {
        $this->request = $request;
    }

    /**
     *
     * @return Request
     */
    public function &getRequest() {
        return $this->request;
    }

    public function &getConfig() {
        return $this->config;
    }

    /**
     *
     * @param AppConfig $config 
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
     */
    public function setRouting(Routing $routing) {
        $this->routing = $routing;
    }
}