<?php

namespace Hirudo\Impl\StandAlone;

use Hirudo\Core\Context\Routing as Routing;
use Hirudo\Impl\StandAlone\lib\JURI;

/**
 * 
 * @Hirudo\Core\Annotations\Export(id="routing")
 */
class SARouting extends Routing {

    public function appAction($app, $module, $task = "index", $params = array()) {

        $uri = JURI::getInstance();
        $query = $uri->getQuery(true);

        $query["controller"] = "$app.$module";
        $query["task"] = $task;

        $query = array_merge($query, $params);

        return $uri->toString(array('scheme', 'user', 'pass', 'host', 'port', 'path')) . "?" . $uri->buildQuery($query);
    }

    public function redirect($url) {
        header("Location: $url");
    }

    public function getBaseURL() {
        $uri = JURI::getInstance();
        return $uri->toString();
    }

}

?>