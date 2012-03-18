<?php

namespace Hirudo\Impl\Common\Templating;

use Hirudo\Core\TemplatingInterface;
use Hirudo\Core\Annotations\Export;

\Hirudo\Lang\Loader::using("framework::libs::smarty::Smarty.class");

/**
 * Has the only smarty instance. Allows adding variables to the view and 
 * rendering any view from the module.
 *
 * @Export(id="templating", factory="instance")
 * 
 */
class SmartyTemplating implements TemplatingInterface {

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
     * @var SmartyTemplating
     */
    private static $instance;

    /**
     *
     * @return SmartyTemplating
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new SmartyTemplating();
        }

        return self::$instance;
    }

}

?>
