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
 *  Hirudo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 * 
 *  You should have received a copy of the GNU General Public License
 *  along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Core;

/**
 * <p>An interface for any templating system such as Smarty, Twig, PATemplate, etc.</p>
 * 
 * <p>Implementors must be capable of loading and rendering the template resource
 * based on the view name.</p>
 * 
 * @author JeyDotC
 */
interface TemplatingInterface {

    /**
     * <p>Adds a variable to the view so it can be accessed from the template.</p>
     * 
     * @param string $name The name that the variable will adopt.
     * @param mixed $value The value of the variable.
     * @return mixed The assigned value 
     */
    public function assign($name, $value);

    /**
     * Renders the view and retuns it as a string.
     * 
     * @param string $moduleDir The absolute path to the module.
     * @param string $view The name of the view to be rendered.
     * 
     * @return string The output of the view as a string. 
     */
    public function display($moduleDir, $view);
    
    /**
     * Tells to the Templating system the location of an extensions folder, allowing
     * it to load and use its extensions.
     * 
     * @param string $path
     * @return void 
     */
    public function addExtensionsPath($path);
}

?>
