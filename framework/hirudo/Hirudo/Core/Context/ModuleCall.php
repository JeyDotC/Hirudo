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

use Hirudo\Core\Exceptions\HirudoException;

/**
 * This class represents a call to a task from a module that
 * belongs to an application.
 * 
 * @author JeyDotC
 */
class ModuleCall {

    private $app;
    private $module;
    private $task;
    /**
     *
     * @var HirudoException
     */
    private $lastUnhandledException;

    /**
     * Creates a module call.
     * 
     * @param string $app The application the requested module belongs to.
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
    
    public function isEmpty() {
        return empty($this->app) && empty($this->module);
    }

    /**
     * A factory method to create a module call from a string with the "AppName::ModuleName::taskName"
     * format.
     * 
     * @param string $string A string with the "AppName::ModuleName::taskName" format.
     * @return \Hirudo\Core\Context\ModuleCall A new instance of ModuleCall.
     */
    public static function fromString($string) {
        $parts = explode("::", $string);
        return new ModuleCall($parts[0], $parts[1], $parts[2]);
    }

    /**
     * Gets the name of the requested application.
     * 
     * @return string The application name.
     */
    public function getApp() {
        return $this->app;
    }

    /**
     * Sets the name of the requested application.
     * 
     * @param string $app the application name
     */
    public function setApp($app) {
        $this->app = $app;
    }

    /**
     * Gets the name of the requested module.
     * 
     * @return string The module name.
     */
    public function getModule() {
        return $this->module;
    }

    /**
     * sets the name of the requested module.
     * 
     * @param string $module The module name.
     */
    public function setModule($module) {
        $this->module = $module;
    }

    /**
     * Gets the name of the requested task.
     * 
     * @return string The task name 
     */
    public function getTask() {
        return $this->task;
    }

    /**
     * Sets the name of the requested task.
     * 
     * @param string $task The task name.
     */
    public function setTask($task) {
        $this->task = $task;
    }

    /**
     * Gets the last Unhandled exception from a previous module execution.
     * 
     * @return HirudoException An instance of HirudoException, null if there were no exceptions on a previous module excecution.
     */
    public function getLastUnhandledException() {
        return $this->lastUnhandledException;
    }

    /**
     * Sets the last Unhandled exception from a previous module execution.
     * 
     * @param HirudoException $lastUnhandledException 
     */
    public function setLastUnhandledException(HirudoException $lastUnhandledException) {
        $this->lastUnhandledException = $lastUnhandledException;
    }

    /**
     * Were there an exception from a previous module execution?
     * 
     * @return boolean 
     */
    public function hasUnhandledException() {
        return $this->lastUnhandledException instanceof HirudoException;
    }
    
    /**
     * Represents this module call as string with the "AppName::ModuleName::taskName" format.
     * 
     * @return string
     */
    public function __toString() {
        return "$this->app::$this->module::$this->task";
    }

}

?>
