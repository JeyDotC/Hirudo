<?php

namespace Hirudo\Impl\Joomla;
use Hirudo\Core\Context\Routing as Routing;

require_once "JoomlaHelper.php";

/**
 * @Export(id="routing")
 */
class JoomlaRouting extends Routing {

    public function appAction($app, $module, $task = "index", $params = array()) {
        $mainframe = JoomlaHelper::getMainframe();

        $itemId = JRequest::getVar("Itemid", 2);
        $uri = JURI::getInstance();
        $query = $uri->getQuery(true);

        $query["option"] = $mainframe->scope;
        $query["Itemid"] = $itemId;
        $query["controller"] = "$app.$module";
        $query["task"] = $task;

        $query = array_merge($query, $params);

        return $uri->toString(array('scheme', 'user', 'pass', 'host', 'port', 'path')) . "?" . $uri->buildQuery($query);
    }

    public function redirect($url) {
        $mainframe = JoomlaHelper::getMainframe();
        $mainframe->redirect($url);
    }

    public function getBaseURL() {
        $uri = JURI::getInstance();
        return $uri->toString();
    }

}

?>
