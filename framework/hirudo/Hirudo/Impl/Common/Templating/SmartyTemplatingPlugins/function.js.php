<?php

use Hirudo\Core\Context\ModulesContext;

/**
 * Generates a script tag. 
 * Usage: <code>{script file="path/to/my/jsFile.js"}</code>
 * 
 * @param array $params
 * @param type $template
 * 
 * @return string The resulting script tag.
 * 
 * @see \Hirudo\Core\Context\Assets For more information about assets management.
 */
function smarty_function_js($params, $template) {
    $path = $params["file"];
    $external = isset($params["external"]) && $params["external"];
    return ModulesContext::instance()->getAssets()->addJavaScript($path, $external);
}
?>
