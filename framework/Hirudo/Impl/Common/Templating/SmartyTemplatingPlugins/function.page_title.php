<?php

function smarty_function_page_title($params, $template) {
    $pageContext = Hirudo\Core\Context\ModulesContext::instance()->getPage();

    $content = "";
    if (isset($params["t"]) && !$pageContext->setTitle($params["t"])->renderTitle()) {
        $content = $params["t"];
    }

    return $content;
}

?>
