<?php

namespace Hirudo\Core\Context;

use Hirudo\Core\Exceptions\HirudoException;

/**
 * This class describes the call to an especific module of an application.
 * Sepecifies the the task that a module of a sertain application should
 * execute.
 *
 * @author JeyDotC
 */
class ModuleCall {

    private $app;
    private $module;
    private $task;
    private $lastUnhandledException;

    /**
     * Creates a module call.
     * 
     * @param string $app The application the desired module belongs to.
     * @param string $module The module to be executed.
     * @param string $task The task this module should execute.
     * @param UnderscoreException $lastUnhandledException If there where any unhandled exception on a previous module excecution.
     */
    function __construct($app, $module, $task = "index",
            UnderscoreException $lastUnhandledException = null) {
        $this->app = $app;
        $this->module = $module;
        $this->task = $task;
        $this->lastUnhandledException = $lastUnhandledException;
    }
    
    /**
     *
     * @param string $string
     * @return \Hirudo\Core\Context\ModuleCall 
     */
    public static function fromString($string){
        $parts = explode("::", $string);
        return new ModuleCall($parts[0], $parts[1], $parts[2]);
    }

    public function getApp() {
        return $this->app;
    }

    public function setApp($app) {
        $this->app = $app;
    }

    public function getModule() {
        return $this->module;
    }

    public function setModule($module) {
        $this->module = $module;
    }

    public function getTask() {
        return $this->task;
    }

    public function setTask($task) {
        $this->task = $task;
    }

    /**
     *
     * @return UnderscoreException 
     */
    public function getLastUnhandledException() {
        return $this->lastUnhandledException;
    }

    public function setLastUnhandledException(HirudoException $lastUnhandledException) {
        $this->lastUnhandledException = $lastUnhandledException;
    }

    public function hasUnhandledException() {
        return $this->lastUnhandledException instanceof HirudoException;
    }

}

?>
