<?php

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
    protected $loaders = array();

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
     * @param type $taskName
     * @return \Hirudo\Core\Task 
     */
    public function getTask($taskName) {
        foreach ($this->loaders as &$loader) {
            $loader->setModuleName($this->name);
            $loader->setApp($this->appName);
        }

        $this->currentTask = $this->defaultTask;

        if (method_exists($this, $taskName)) {
            $this->currentTask = $taskName;
        }

        $this->onModuleReady();

        $reflection = new \ReflectionClass($this);
        $task = new Task($reflection->getMethod($this->currentTask));

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

    public function getLoaders() {
        return $this->loaders;
    }

    /**
     *
     * @param array $loaders
     *
     * //import-many Loader
     */
    public function setLoaders($loaders) {
        foreach ($loaders as &$loader) {
            if ($loader instanceof AbstractLoader) {
                $this->loaders[get_class($loader)] = $loader;
            }
        }
    }

    /**
     *
     * @param string $name
     * @return AbstractLoader
     */
    public function __get($name) {
        if (!array_key_exists($name . "Loader", $this->loaders)) {
            throw new Exception("There is no loader named '$name'");
        }
        return $this->loaders[$name . "Loader"];
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

    /**
     * The default task of the module.
     */
    public abstract function index();

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