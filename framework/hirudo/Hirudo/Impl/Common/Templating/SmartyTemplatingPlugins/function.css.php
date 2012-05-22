<?php

use Hirudo\Core\Context\ModulesContext;

/**
 * Generates a css link tag. 
 * Usage: <code>{css file="path/to/my/cssFile.css"}</code>
 * 
 * @param array $params
 * @param type $template
 * 
 * @return string The resulting link tag.
 * 
 * @see \Hirudo\Core\Context\Assets For more information about assets management.
 */
function smarty_function_css($params, $template) {
    $path = $params["file"];
    
    return ModulesContext::instance()->getAssets()->addCSS($path);
}
?>
