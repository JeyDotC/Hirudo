<?php

/**
 *
 * @param array $params
 * @param Smarty_Internal_Template $template
 * @return <type>
 */
function smarty_function_bind($params, $template) {
    $to = $params["to"];
    $route = explode(".", $to);
    $name = array_shift($route);

    foreach ($route as $key) {
        $index = "";
        $bracketPosition = strpos($key, "[");
        
        if ($bracketPosition !== false) {
            $index = substr($key, $bracketPosition);
            $key = substr($key, 0, $bracketPosition);
        }
        
        $name .= "[$key]$index";
    }

    return "name=\"$name\"";
}

?>
