<?php

use Hirudo\Lang\Loader;

/**
 * <p>Converts the given string into a valid absolute path like smarty_modifier_toPath
 * plugin, but this time the path has only three parts, the application, the 
 * module and the view name, so any view from any module can be included or inherited.
 *  
 * @param string $string The complete name of the view with format AppName::ModuleName::viewName
 * 
 * @return string The resulting path.
 * 
 * @see Loader::using() For details about the string format required by this 
 * method.
 * 
 * @throws InvalidPathException If $string is not a string, is null or is empty.
 * @throws LogicException If $extension is not a string.
 */
function smarty_modifier_toViewPath($string) {
    $base = Hirudo\Core\Context\ModulesContext::instance()->getConfig()->get("businessRoot", "src");

    $parts = explode("::", $string);

    $resultingPath = Loader::toSinglePath("$base{$parts[0]}::Modules::{$parts[1]}::{$parts[2]}", ".tpl");

    return $resultingPath;
}

?>