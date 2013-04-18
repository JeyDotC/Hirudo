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

use Hirudo\Core\Annotations\Import;
use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Context\Request;
use Hirudo\Core\Context\Routing;
use Hirudo\Core\Context\Session;
use Hirudo\Core\Task;
use Hirudo\Core\Util\Message;
use Hirudo\Lang\Loader;
use ReflectionClass;

/**
 * A class that allows the edition of the response headers.
 */
class HeaderBag {

    /**
     * Sets a header value.
     * 
     * @param string $key The header key.
     * @param string|array $value The header value. If the value is an array, all of its elements are added under the same key given as the first parameter.
     * @param boolean $replace Tells if the new value shall replace the existing one.
     */
    public function setHeader($key, $value, $replace = true) {
        if (is_array($value)) {
            foreach ($value as $header) {
                $this->setHeader($key, $header, false);
            }
        } else {
            $this->addHeader("$key: $value", $replace);
        }
    }

    /**
     * <p>Adds the given headers list.</p>
     * 
     * <p>The array can have any conbination of these elements styles.</p>
     * 
     * <div>
     * <code>
     * array(
     *      "Header-Key" => "Header-Value", //Key/Value pairs
     *      "Header-Key: Header-Value", //Single values with all header information in a single string
     *      "Header-Key" => array("Value1", "Value2", "...ValueN"), //A list of header values under a single key.
     * )
     * </code>
     * </div>
     * 
     * @param array $headers List of headers. 
     */
    public function setHeaders(array $headers) {
        foreach ($headers as $key => $value) {
            if (is_numeric($key)) {
                $this->addHeader($value);
            } else {
                $this->setHeader($key, $value);
            }
        }
    }

    /**
     * <p>An utility method that causes the resulting output to be downloaded
     * instead of being rendered in browser.</p>
     * 
     * @param string $mime The mime type of the file to be downloaded.
     * @param string $filename A file name for the file to be downloaded.
     */
    public function setContentsForDownload($mime, $filename) {
        $this->setHeaders(array(
            "Content-type" => $mime,
            "Content-Disposition" => "attachment;filename=$filename",
            "Content-Transfer-Encoding" => "binary",
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ));
        set_time_limit(0);
    }

    private function addHeader($header, $replace = true) {
        header($header, $replace);
    }

}

class Redirection {

    private $url;

    function __construct($url) {
        $this->url = $url;
    }

    public function getUrl() {
        return $this->url;
    }

}

/**
 * A module represents a single use case in the business logic.
 * 
 */
abstract class Module {

    /**
     * The name of the application this module belongs to.
     * 
     * @var string
     */
    private $appName = "";

    /**
     * This module's name.
     * 
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
     * The name of the task being executed.
     * 
     * @var string
     */
    private $currentTask;
    private $defaultTask = "index";

    /**
     * Data associated to this module.
     * 
     * @var array
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
    protected $context;

    /**
     * An utility object for response header edition.
     * 
     * @var HeaderBag
     */
    protected $headers;

    /**
     *
     * @var Session 
     */
    protected $session;
    
    /**
     *
     * @var Context\Page
     */
    protected $page;

    /**
     * @var array<mixed> 
     * 
     * @todo #decision: Make this static?
     */
    private $loadedComponents = array();

    /**
     *
     * @var ReflectionClass 
     */
    private $reflector;

    /**
     * Adds a variable to the view so it can access it via the name.
     * 
     * @param string $name The name of the variable.
     * @param mixed $value The value of the variable.
     * 
     * @see TemplatingInterface->assign()
     */
    protected function assign($name, $value) {
        $this->view->assign($name, $value);
    }

    /**
     * Batch assign.
     * 
     * @param array $array A list of key/value pairs where keys are the variable names.
     */
    protected function assignMany(array $array) {
        foreach ($array as $name => $value) {
            $this->assign($name, $value);
        }
    }

    /**
     * Retreives a component instance.
     * 
     * @param string $name The name of the component in "ComponentName" or "AppName::ComponentName"
     * format.
     * 
     * @return mixed The resulting component.
     */
    protected function component($name) {
        $app = $this->appName;
        $componentName = str_replace("/", "\\", $name);

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
     * Builds a task from it's name. If the module doesn't have a corresponding
     * method, the default task is returned, normally the "index" task.
     * 
     * @param string $taskName Thask's name.
     * @return Task The representation of the task to be executed.
     */
    public function getTask($taskName) {
        $this->onModuleReady();

        $this->currentTask = $this->defaultTask;

        if (method_exists($this, $taskName)) {
            $this->currentTask = $taskName;
        }

        $reflection = new ReflectionClass($this);
        $task = new Task($reflection->getMethod($this->currentTask), $this);

        return $task;
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
     * <p>Displays the given view to the browser.</p>
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
     *              <li>appName =&gt; The the name of the application this module belongs to.</li>
     *              <li>name =&gt; The name of this module.</li>
     *              <li>task =&gt; The task that have been requested.</li>
     *              <li>context =&gt; A reference to the ModulesContext instance.</li>
     *              <li>views =&gt; The absolute path to the views folder for this module. [This value seems to be unnecesary, is left for historical reasons]</li>
     *              <li>baseURL =&gt; The current base URL</li>
     *              <li>messages =&gt; The list of added {@link Message} objects</li>
     *          </ul>
     *          
     *      </dd>
     * </dl>
     * 
     * @param string $view The view name. It can be just the view name if it belongs
     * to the current module or a string with the "AppName::ModuleName::viewName" format
     * if the view belongs to another module.
     */
    protected function display($view, array $data = array()) {
        $this->assignMany($data);
        $viewParts = $this->_getViewParts($view);

        $this->module["appName"] = $this->appName;
        $this->module["name"] = $this->name;
        $this->module["task"] = $this->currentTask;
        $this->module["context"] = $this->context;
        $this->module["views"] = "{$this->getModuleDir($this->appName, $this->name)}" . "views" . DS;
        $this->module["businessRoot"] = Loader::toSinglePath($this->context->getConfig()->get("businessRoot", "src"), DS);
        $this->module["baseURL"] = $this->route->getBaseURL();
        $this->module["page"] = $this->page;

        $this->assign("Module", $this->module);

        return $this->view->display($this->getModuleDir($viewParts["app"], $viewParts["module"]) . "views" . DS . $viewParts["view"]);
    }

    /**
     * Adds a message to the view which normally will be rendered as a notification.
     * 
     * @param Message $message The message to be displayed.
     */
    public function addMessage(Message $message) {
        $this->module["messages"][] = $message;
    }

    /**
     * Sets the name of the default task. By default is "index".
     * 
     * @param string $defaultTask 
     */
    public function setDefaultTask($defaultTask) {
        $this->defaultTask = $defaultTask;
    }

    /**
     * I don't trust PHP constructors anymore ¬¬
     * 
     * @param string $className
     */
    public static function createModuleFromClassName($className) {
        if (!class_exists($className)) {
            throw new Exceptions\HirudoException(ModulesContext::instance()->getCurrentCall(), "Class '$className' couldn't be loaded or does not exist.");
        }

        if (!is_subclass_of($className, "Hirudo\Core\Module")) {
            throw new Exceptions\HirudoException(ModulesContext::instance()->getCurrentCall(), "'$className' must inherit from Hirudo\Core\Module");
        }

        /* @var $newModule Module */
        $newModule = new $className();
        $newModule->reflector = new ReflectionClass($newModule);
        $newModule->headers = new HeaderBag();
        $newModule->context = ModulesContext::instance();
        $newModule->name = $newModule->reflector->getShortName();
        $newModule->currentUser = $newModule->context->getCurrentUser();
        $newModule->request = $newModule->context->getRequest();
        $newModule->route = clone $newModule->context->getRouting();
        $newModule->route->setModuleName($newModule->name);
        $newModule->view = $newModule->context->getTemplating();
        $namespaceParts = explode("\\", $newModule->reflector->getNamespaceName());
        $newModule->appName = $namespaceParts[0];
        $newModule->route->setAppName($newModule->appName);
        $newModule->session = $newModule->context->getSession();
        $newModule->page = $newModule->context->getPage();

        return $newModule;
    }

    private function _getViewParts($view) {
        $viewParts = array(
            "app" => $this->appName,
            "module" => $this->name,
            "view" => $this->currentTask,
        );

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
     * Gets the directory in which this module is located.
     * 
     * @return string The directory that contains this module. 
     */
    public function getModuleDir($appName, $name) {
        $dir = Loader::toSinglePath("$appName::Modules::$name::", "");
        return $dir;
    }

    /**
     * Gets the module's name.
     * 
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Gets the name of the app this module belongs to.
     * 
     * @return string 
     */
    public function getAppName() {
        return $this->appName;
    }

    protected function redirect($url) {
        return new Redirection($url);
    }

}

?>
