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
