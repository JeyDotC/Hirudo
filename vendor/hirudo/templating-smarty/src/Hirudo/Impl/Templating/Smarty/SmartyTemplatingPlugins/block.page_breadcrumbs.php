<?php

function smarty_block_page_breadcrumbs($params, $content, Smarty_Internal_Template $template, &$repeat) {
    $pageContext = Hirudo\Core\Context\ModulesContext::instance()->getPage();

    if ($repeat) {
        $breadcrumbs = isset($params["b"]) ? $params["b"] : array();
        foreach ($breadcrumbs as $title => $url) {
            $pageContext->addBreadcrumb($title, $url);
        }
        $repeat = !$pageContext->renderBreadcrumbs();
    } else {
        return $content;
    }
}

?>
