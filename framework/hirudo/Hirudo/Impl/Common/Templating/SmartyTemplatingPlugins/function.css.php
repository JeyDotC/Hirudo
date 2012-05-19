<?php

use Hirudo\Core\Context\ModulesContext;

/**
 * 
 */
function smarty_function_css($params, $template) {
    $path = $params["file"];
    
    return ModulesContext::instance()->getAssets()->addCSS($path);
}
?>
