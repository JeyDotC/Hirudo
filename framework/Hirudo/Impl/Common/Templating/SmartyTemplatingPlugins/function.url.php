<?php

/**
 * «Copyright 2012 Jeysson José Guevara Mendivil(JeyDotC)» 
 * 
 * This file is part of Hirudo.
 * 
 * Hirudo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Hirudo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

use Hirudo\Core\Context\ModulesContext;

/**
 * Returns a URL based on the string given in the call attribute.
 * Usage: <code>{url call="AppName::ModuleName::taskName"}</code> Any extra
 * parameters will be used as params for the url. For example, if we have:
 * <code>{url call="AppName::ModuleName::taskName" id=123 name="MyName"}</code>
 * the resulting url will be the same if we called:
 *  <code>
 * $aRoutingObject->appAction("AppName", "ModuleName", "taskName",  
 *      array(
 *          "id"=>123, 
 *          "name"=>"MyName"
 *      )
 * );
 * </code>
 * 
 * @param array $params
 * @param Smarty_Internal_Template $template
 * 
 * @return string The generated URL.
 * @see \Hirudo\Core\Context\Routing For more information about Hirudo URLs
 */
function smarty_function_url($params, $template) {
    $route = ModulesContext::instance()->getRouting();

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
