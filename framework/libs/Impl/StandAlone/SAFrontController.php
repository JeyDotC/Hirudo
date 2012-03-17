<?php
/**
 * The underscore front controller implementation for joomla.
 *
 * @author Virtualidad
 */
class SAFrontController implements UnderscoreFrontController {

    /**
     *
     * @var UnderscoreFrontControllerHelper 
     */
    private $frontControllerHelper;

    /**
     * Constructs this controller as a joomla controller.
     */
    public function __construct() {
        //Get the helper to execute the task.
        $this->frontControllerHelper = UnderscoreFrontControllerHelper::instance();
    }

    public function run() {
        $call = $this->buildCallFromRequest();

        $html = $this->frontControllerHelper->invokeModule($call);

        if (isset($html)) {
            echo $html;
        }
    }

    /**
     * Creates a call from request data.
     * 
     * @return ModuleCall 
     */
    private function buildCallFromRequest() {

        $call = $this->frontControllerHelper->getDefaultModuleCall();
        $controller = $this->get("controller");

        if (!empty($controller)) {

            $moduleRoute = explode(".", $controller);
            if ($this->frontControllerHelper->applicationExists($moduleRoute[0])) {
                $call->setApp($moduleRoute[0]);
            }

            if (!empty($moduleRoute[1])) {
                $call->setModule($moduleRoute[1]);
            }
        }

        $task = $this->get("task", "index");
        $call->setTask($task);

        return $call;
    }
	
	private function get($key, $default = null){
		return isset($_GET[$key]) ? $_GET[$key] : $default;
	}
}

?>
