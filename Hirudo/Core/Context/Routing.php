<?php

namespace Hirudo\Core\Context;

/**
 * A class to create internal routes.
 *
 * @author Virtualidad
 */
abstract class Routing {

    private $appName = "";
    private $moduleName = "";

    public function action($task, $params = array()) {
        return $this->moduleAction($this->moduleName, $task, $params);
    }

    public function moduleAction($module, $task = "index",
            $params=array()){
        return $this->appAction($this->appName, $module, $task, $params);
    }

    public abstract function appAction($app, $module, $task = "index",
            $params=array());
			
    public abstract function getBaseURL();

    public abstract function redirect($url);

    public function getModuleName() {
        return $this->moduleName;
    }

    public function setModuleName($moduleName) {
        $this->moduleName = $moduleName;
    }

    public function getAppName() {
        return $this->appName;
    }

    public function setAppName($appName) {
        $this->appName = $appName;
    }

}

?>
