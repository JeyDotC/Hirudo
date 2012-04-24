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

namespace Hirudo\Core;

use Hirudo\Core\Util\Message;
use Hirudo\Core\Context\ModulesContext;
use Hirudo\Lang\Loader as Loader;
use Hirudo\Core\Context\Request;
use Hirudo\Core\Annotations\Import;
use Hirudo\Core\Context\Routing;
use Hirudo\Core\Exceptions\HirudoException;

/**
 * A module represents a single use case in the business logic.
 * 
 */
abstract class Module {

    /**
     *
     * @var string The name of the application this module belongs to.
     */
    private $appName = "";

    /**
     * This module name.
     * @var string
     */
    private $name;

    /**
     * The templates manager associated to this module.
     * 
     * @var TemplatingInterface
     */
    private $view;

    /**
     *
     * @var string The result of the rendering 
     */
    private $rendered = null;
    private $currentTask;
    private $defaultTask = "index";

    /**
     *
     * @var array Data associated to this module.
     */
    private $module = array("messages" => array());

    /**
     * The current user of this session.
     * 
     * @var Context\Principal
     */
    protected $currentUser;

    /**
     * A helper class for managing urls.
     * 
     * @var Routing
     */
    protected $route;

    /**
     * Gives access to the request arrays such as GET, POST or SESSION.
     * 
     * @var Request
     */
    protected $request;

    /**
     * An internal ModulesContext instance.
     * 
     * @var ModulesContext 
     */
    private $context;

    /**
     *
     * @var type 
     * 
     * #decision: Make this static?
     */
    private $loadedComponents = array();

    /**
     * Adds a variable to the view.
     * 
     * @param string $name
     * @param mixed $value 
     * @see TemplatesManager->assign()
     */
    protected function assign($name, $value) {
        $this->view->assign($name, $value);
    }

    /**
     *
     * @param array $array 
     */
    protected function assignMany(array $array) {
        foreach ($array as $name => $value) {
            $this->assign($name, $value);
        }
    }

    /**
     *
     * @param string $name The name of the component in "ComponentName" or "AppName::ComponentName"
     * format.
     * 
     * @return mixed
     */
    protected function component($name) {
        $app = $this->appName;
        $componentName = $name;

        $parts = explode("::", $name);
        if (count($parts) > 1) {
            $app = $parts[0];
            $componentName = $parts[1];
        }

        $componentClass = "$app\\Models\\Components\\{$componentName}Component";

        if (!array_key_exists($componentClass, $this->loadedComponents)) {
            $component = new $componentClass();
            $this->context->getDependenciesManager()->resolveDependencies($component);
            $this->loadedComponents[$componentClass] = $component;
        } else {
            $component = $this->loadedComponents[$componentClass];
        }

        return $component;
    }

    /**
     *
     * @param type $taskName
     * @return \Hirudo\Core\Task 
     */
    public function getTask($taskName) {
        $this->onModuleReady();

        $this->currentTask = $this->defaultTask;

        if (method_exists($this, $taskName)) {
            $this->currentTask = $taskName;
        }

        $reflection = new \ReflectionClass($this);
        $task = new Task($reflection->getMethod($this->currentTask), $this);

        return $task;
    }

    /**
     *
     * @return string 
     */
    public function getRendered() {
        return $this->rendered;
    }

    /**
     * This function is called before a task execution, is
     * useful for taking actions prior the execution of any task such as 
     * initializing objects common to all tasks.
     */
    protected function onModuleReady() {
        //Do Nothing.
    }

    /**
     * <p>Displays the given view of the current module.</p>
     * 
     * <p>In adition to the data provided by the module, the view will have these
     * variables available.</p>
     * 
     * <dl>
     *      <dt>Module</dt>
     *      <dd>
     *          An array with data about this module. The array consists of these
     *          values:
     *          <ul>
     *              <li>meta =&gt; The metadata asociated to this module. (MetadataCollection)</li>
     *              <li>appName =&gt; The the name of the application this module belongs to.</li>
     *              <li>name =&gt; The name of this module.</li>
     *              <li>context =&gt; A reference to the ModulesContext instance.</li>
     *              <li>views =&gt; The absolute path to the views folder for this module.</li>
     *              <li>baseURL =&gt; The current base URL</li>
     *              <li>messages =&gt; The list of added {@link Message} objects</li>
     *          </ul>
     *          
     *      </dd>
     * </dl>
     * 
     * @param type $view 
     */
    protected function display($view = null) {
        $viewParts = $this->getViewParts($view);

        $this->module["appName"] = $this->appName;
        $this->module["name"] = $this->name;
        $this->module["task"] = $this->currentTask;
        $this->module["context"] = $this->context;
        $this->module["views"] = "{$this->getModuleDir($this->appName, $this->name)}" . "views" . DS;
        $this->module["businessRoot"] = Loader::toSinglePath($this->context->getConfig()->get("businessRoot", "src"), DS);
        $this->module["baseURL"] = $this->route->getBaseURL();

        $this->assign("Module", $this->module);

        $this->rendered = $this->view->display($this->getModuleDir($viewParts["app"], $viewParts["module"]), $viewParts["view"]);
    }

    /**
     * Adds a message to the view which normally will be rendered as a notification.
     * 
     * @param Message $message 
     */
    public function addMessage(Message $message) {
        $this->module["messages"][] = $message;
    }

    /**
     *
     * @param TemplatingInterface $templateManager 
     * 
     * @Import(id="templating")
     */
    public function setTemplateManager(TemplatingInterface $templateManager) {
        $this->view = $templateManager;
    }

    public function setDefaultTask($defaultTask) {
        $this->defaultTask = $defaultTask;
    }

    function __construct() {
        $this->context = ModulesContext::instance();
        $this->name = $this->getUnqualifiedClassName(get_class($this));
        $this->currentUser = $this->context->getCurrentUser();
        $this->request = $this->context->getRequest();
        $this->route = $this->context->getRouting();
        $this->route->setModuleName($this->name);
    }

    private function getViewParts($view) {
        $viewParts = array("app" => $this->appName, "module" => $this->name, "view" => $this->currentTask,);

        if (!empty($view)) {
            $viewPartsFound = explode("::", $view);
            $count = count($viewPartsFound);

            if ($count == 3) {
                $viewParts["app"] = $viewPartsFound[0];
                $viewParts["module"] = $viewPartsFound[1];
                $viewParts["view"] = $viewPartsFound[2];
            } else if ($count == 2) {
                $viewParts["module"] = $viewPartsFound[0];
                $viewParts["view"] = $viewPartsFound[1];
            } else {
                $viewParts["view"] = $viewPartsFound[0];
            }
        }

        return $viewParts;
    }

    /**
     * Gets the path to this module.
     * 
     * @return string The directory that contains this module. 
     */
    public function getModuleDir($appName, $name) {
        $base = $this->context->getConfig()->get("businessRoot", "src");
        if (!empty($base)) {
            $base .= "::";
        }

        $dir = Loader::toSinglePath("$base$appName::Modules::$name::", "");
        return $dir;
    }

    public function getName() {
        return $this->name;
    }

    public function getAppName() {
        return $this->appName;
    }

    public function setAppName($appName) {
        $this->appName = $appName;
        $this->route->setAppName($this->appName);
    }

    /**
     *
     * @return HirudoException 
     */
    public function getLastUnhandledException() {
        return $this->context->getCurrentCall()->getLastUnhandledException();
    }

    private function getUnqualifiedClassName($qualifiedClassName) {
        $name = $qualifiedClassName;

        $lastBackSlashPos = strrpos($qualifiedClassName, "\\");
        if ($lastBackSlashPos !== false) {
            $name = substr($qualifiedClassName, $lastBackSlashPos + 1);
        }

        return $name;
    }

}

?>
