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
function smarty_modifier_toPath($string, $extension = ".tpl") {
    $resultingPaths = Loader::toSinglePath($string, $extension);
    return $resultingPaths;
}

?>