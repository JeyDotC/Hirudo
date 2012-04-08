<?php
use Hirudo\Core\Context\ModulesContext;
/**
 *
 * @param array $params
 * @param Smarty_Internal_Template $template
 * @return <type>
 */
function smarty_function_url($params, $template) {
    $route = ModulesContext::instance()->getRouting();
    $url = "";
	
	$action = $params["call"];
	unset($params["call"]);
	
	$parts = explode("::", $action);
	$app = $parts[0];
	$module = isset($parts[1]) ? $parts[1] : "";
	$task = isset($parts[2]) ? $parts[2] : "index";
	
	$url = $route->appAction($app, $module, $task, $params);
	
    return $url;
}

?>
