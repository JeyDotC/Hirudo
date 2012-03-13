<?php

namespace Hirudo\Core;

/**
 * Has the only smarty instance. Allows adding variables to the view and 
 * rendering any view from the module.
 *
 * @export TemplatesManager
 * @export-metadata singleinstance
 * @export-metadata static-factory:instance
 */
class TemplatesManager {

    /**
     *
     * @var Smarty
     */
    private $smarty;

    function __construct() {
        $this->smarty = new Smarty();
        Loader::using("ext::smarty-plugins::*");
        $isDebuging = ModulesContext::instance()->getConfig()->get("debug");
        if ($isDebuging) {
            $this->smarty->caching = false;
        }
    }

    /**
     * <p>Adds a variable to the view so it can be accessed from the smarty template.</p>
     * 
     * @param string $name The name that the variable will adopt.
     * @param mixed $value The value of the variable.
     * @return mixed The assigned value 
     */
    public function assign($name, $value) {
        $this->smarty->assign($name, $value);
        return $value;
    }

    /**
     * Renders the view and retuns it as a string.
     * 
     * @param string $moduleDir The absolute path to the module.
     * @param string $view The name of the view to be rendered.
     * 
     * @return string The output of the view as a string. 
     */
    public function display($moduleDir, $view) {
        return $this->smarty->fetch("file:" . $moduleDir . "views" . DS . "$view.tpl");
    }

    /**
     *
     * @var TemplatesManager
     */
    private static $instance;

    /**
     *
     * @return TemplatesManager
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new TemplatesManager();
        }

        return self::$instance;
    }

}

?>
