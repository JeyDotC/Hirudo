<?php

use Hirudo\Core\Context\ModuleCall;
use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Util\Message;

function smarty_function_page_add_message($params, $template) {
    $pageContext = ModulesContext::instance()->getPage();

    $title = isset($params["title"]) ? $params["title"] : "";
    $message = isset($params["message"]) ? $params["message"] : "";
    $type = isset($params["type"]) ? $params["type"] : "";

    $pageContext->addMessage(new Message($message, $title, $type));

    return "";
}

?>
