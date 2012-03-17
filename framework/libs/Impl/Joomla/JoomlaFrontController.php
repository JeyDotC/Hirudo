<?php

namespace Hirudo\Impl\Joomla;

defined('_JEXEC') or die('Restricted access');

require_once "JoomlaHelper.php";

function joomlaAutoloader($class) {
    if (JLoader::load($class)) {
        return true;
    }
    return false;
}

/**
 * A fix for joomla autoloader, joomla took the wrong desition of overriding
 * the __autoload function instead of registering one via the spl_autoload_register
 * function.
 */
spl_autoload_register("joomlaAutoloader");

jimport('joomla.application.component.controller');

/**
 * The underscore front controller implementation for joomla.
 *
 * @author Virtualidad
 */
class JawFrontController extends JController implements UnderscoreFrontController {

    /**
     *
     * @var JView
     */
    private $view;

    /**
     *
     * @var UnderscoreFrontControllerHelper 
     */
    private $frontControllerHelper;

    /**
     * Constructs this controller as a joomla controller.
     */
    public function __construct() {
        //As this is not at a tipical component is necesary to say where are we.
        parent::__construct(array("base_path" => __DIR__));
        parent::registerDefaultTask("doTask");

        $document = &JFactory::getDocument();
        //Get the view saying where is it.
        $this->view = &$this->getView('_', $document->getType(), '', array("base_path" => __DIR__));

        //Get the helper to execute the task.
        $this->frontControllerHelper = UnderscoreFrontControllerHelper::instance();
    }

    /**
     * Executes the task taken from request data and orders the view to display.
     */
    public function doTask() {

        $call = $this->buildCallFromRequest();

        $html = $this->frontControllerHelper->invokeModule($call);

        if (isset($html)) {
            $this->view->assignRef("html", $html);
            $this->view->display();
        }
    }

    /**
     * Executes a task 
     * 
     * @param string $task
     * @return mixed 
     */
    public function execute($task) {
        $isAjax = JRequest::getVar("ajax", false);

        $mainframe = JoomlaHelper::getMainframe();
        $return = parent::execute($task);

        if ($isAjax) {
            $mainframe->close();
        }

        return $return;
    }

    public function run() {
        $this->execute("");
        $this->redirect();
    }

    /**
     * Creates a call from request data.
     * 
     * @return ModuleCall 
     */
    private function buildCallFromRequest() {

        $call = $this->frontControllerHelper->getDefaultModuleCall();
        $controller = JRequest::getVar("controller", null);

        if (!empty($controller)) {

            $moduleRoute = explode(".", $controller);
            if ($this->frontControllerHelper->applicationExists($moduleRoute[0])) {
                $call->setApp($moduleRoute[0]);
            }

            if (!empty($moduleRoute[1])) {
                $call->setModule($moduleRoute[1]);
            }
        }

        $task = JRequest::getVar("task", "index");
        $call->setTask($task);

        return $call;
    }

}

?>
