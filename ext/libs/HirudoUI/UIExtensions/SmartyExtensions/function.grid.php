<?php

function smarty_function_grid($params, Smarty_Internal_Template $template) {
    $dataSource = $params["for"];
    $gridModel = $params["withModel"];
    /* @var $html UIExtensions\Html\HtmlHelper */
    $html = $template->getTemplateVars("html");
    $result = $html->grid($dataSource)->withModel($gridModel)->toHtmlString();
    return $result;
}
?>
