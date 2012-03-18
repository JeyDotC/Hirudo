<?php

namespace Hirudo\Core;

/**
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
}

?>
