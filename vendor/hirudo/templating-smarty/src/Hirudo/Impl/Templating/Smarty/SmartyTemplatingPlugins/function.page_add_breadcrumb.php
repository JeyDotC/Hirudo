<?php

use Hirudo\Core\Context\ModuleCall;
use Hirudo\Core\Context\ModulesContext;

function smarty_function_page_add_breadcrumb($params, $template) {
    $pageContext = ModulesContext::instance()->getPage();
    $title = isset($params["title"]) ? $params["title"] : "";
    $url = "";
    if (isset($params["call"])) {
        $call = ModuleCall::fromString($params["call"]);
        unset($params["title"]);
        unset($params["call"]);
        $url = ModulesContext::instance()->getRouting()->appAction($call->getApp(), $call->getModule(), $call->getTask(), $params);
    } else if (isset($params["url"])) {
        $url = $params["url"];
    }
    
    $pageContext->addBreadcrumb($title, $url);
            
    return "";
}

?>
