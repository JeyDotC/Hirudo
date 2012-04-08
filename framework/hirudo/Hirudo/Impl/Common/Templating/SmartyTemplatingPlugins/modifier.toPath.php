<?php

use Hirudo\Lang\Loader;

/**
 * <p>Converts the given string into a valid absolute path using the 
 * {@link Loader::toSinglePath()} method.</p>
 * 
 * 
 * @param string $string The path to be converted.
 * @param string $extension = ".tpl" The extension of the required path.
 * @return string The resulting path.
 * 
 * @see Loader::using() For details about the string format required by this 
 * method.
 * 
 * @throws InvalidPathException If $string is not a string, is null or is empty.
 * @throws LogicException If $extension is not a string.
 */
function smarty_modifier_toPath($string, $extension = ".tpl"){
    $resultingPaths = Loader::toSinglePath($string, $extension);
    return $resultingPaths;
}

?>