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

namespace Hirudo\Impl\Common\Templating;

use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Exceptions\TemplateNotFoundException;
use Hirudo\Core\TemplatingInterface;
use Hirudo\Lang\Loader;
use Smarty;

require_once 'helperFunctions.php';

/**
 * A Smarty based templating system.
 *
 * @Hirudo\Core\Annotations\Export(id="templating", factory="instance")
 * 
 */
class SmartyTemplating implements TemplatingInterface {

    /**
     *
     * @var Smarty
     */
    private $smarty;

    /**
     * Creates a new instance of smarty templating.
     */
    function __construct() {
        $this->smarty = new Smarty();
        $this->addExtensionsPath(dirname(__FILE__) . "/SmartyTemplatingPlugins");

        $enviroment = ModulesContext::instance()->getConfig()->get("enviroment");

        if ($enviroment == "dev") {
            $this->smarty->caching = Smarty::CACHING_OFF;
        } else {
            $this->smarty->caching = Smarty::CACHING_LIFETIME_CURRENT;
        }

        $this->smarty->setCacheDir(Loader::toSinglePath("ext::cache::smarty::cache", ""))
                ->setCompileDir(Loader::toSinglePath("ext::cache::smarty::compile", ""));
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
    public function display($view) {
        return $this->smarty->fetch("file:$view.tpl");
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

    /**
     * Adds a path to smarty extensions so these can be used in the templates.
     * 
     * @param string $path The absolute path to the smarty extensions.
     */
    public function addExtensionsPath($path) {
        $this->smarty->addPluginsDir($path);
    }

    public function pick(array $views) {
        foreach ($views as $view) {
            if (file_exists($view)) {
                return $this->display("$view.tpl");
            }
        }

        throw new TemplateNotFoundException(implode(" or ", $views));
    }

    public function getFileExtension() {
        return ".tpl";
    }

}

?>
