<?php

namespace Hirudo\Core\Context;

/**
 * Description of ModulesContext
 *
 * @author Virtualidad
 */
abstract class ModulesContext {

    private static $instance;

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

    public function setCurrentCall(ModuleCall $currentCall) {
        $this->currentCall = $currentCall;
    }

    /**
     * @return Principal
     */
    public abstract function getCurrentUser();

    /**
     * @return Session
     */
    public abstract function &getSession();

    /**
     * @return Request
     */
    public abstract function &getRequest();

    /**
     * @return AppConfig
     */
    public abstract function &getConfig();

    /**
     * @return Routing
     */
    public abstract function getRouting();

    /**
     * @return QueryFactory
     */
//    public abstract function getQueryFactory();

    /**
     *
     * @return array 
     */
    public function getAllModulesMetadata() {
        return Module::$AllModulesMetadata;
    }

    /**
     *
     * @param ModulesContext $instance
     */
    public static function resolveInstance(ModulesContext $instance) {
        self::$instance = $instance;
    }

    /**
     *
     * @return ModulesContext
     */
    public static function instance() {
        return self::$instance;
    }

}

/**
 * @export ModuleContext
 * @export-metadata singleinstance
 * @export-metadata static-factory:instance
 */
class DefaultModulesContext extends ModulesContext {

    private $user;
    private $session;
    private $request;
    private $config;
    private $routing;
//    private $QueryFactory;

    /**
     *
     * @var DefaultModulesContext
     */
    private static $instance;

    /**
     *
     * @return DefaultModulesContext
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
     * @import User
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
     * @import SessionClass
     */
    public function setSession(Session $session) {
        $this->session = $session;
    }

    /**
     *
     * @param Request $request 
     * @import RequestData
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
     * 
     * @import Config
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
     * 
     * @import Router
     */
    public function setRouting(Routing $routing) {
        $this->routing = $routing;
    }

    /**
     *
     * @return QueryFactory 
     */
//    public function getQueryFactory() {
//        return $this->QueryFactory;
//    }

    /**
     *
     * @param QueryFactory $QueryFactory 
     * 
     * @import QueryFactories
     */
//    public function setQueryFactory(QueryFactory $QueryFactory) {
//        $this->QueryFactory = $QueryFactory;
//    }

}
