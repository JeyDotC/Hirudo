<?php

function smarty_function_editor($params, Smarty_Internal_Template $template) {
    $parts = explode(".", $params["for"]);
    $root = array_shift($parts);
    
    $for = $template->getTemplateVars($root);
    $at = implode(".", $parts);
    /* @var $html UIExtensions\HtmlHelper */
    $html = $template->getTemplateVars("html");
    return $html->editor($for, $at, $root);
}
?>
