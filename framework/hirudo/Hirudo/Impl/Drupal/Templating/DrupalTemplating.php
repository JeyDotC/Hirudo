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

namespace Hirudo\Impl\Drupal\Templating;

use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Exceptions\TemplateNotFoundException;
use Hirudo\Core\TemplatingInterface;

/**
 * A delegate based templating system.
 *
 * @Hirudo\Core\Annotations\Export(id="templating", factory="instance")
 * 
 */
class DrupalTemplating implements TemplatingInterface {

    /**
     *
     * @var DrupalTemplate
     */
    private $delegate;

    /**
     * Creates a new instance of delegate templating.
     */
    function __construct() {
        $this->delegate = new DrupalTemplate();
    }

    /**
     * <p>Adds a variable to the view so it can be accessed from the delegate template.</p>
     * 
     * @param string $name The name that the variable will adopt.
     * @param mixed $value The value of the variable.
     * @return mixed The assigned value 
     */
    public function assign($name, $value) {
        $this->delegate->assign($name, $value);
        return $value;
    }

    /**
     * Renders the view and retuns it as a string.
     * 
     * @param string $view The name of the view to be rendered.
     * 
     * @return string The output of the view as a string. 
     */
    public function display($view) {
        return $this->delegate->fetch("$view.php");
    }

    /**
     *
     * @var delegateTemplating
     */
    private static $instance;

    /**
     *
     * @return delegateTemplating
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new DrupalTemplating();
        }

        return self::$instance;
    }

    /**
     * Adds a path to delegate extensions so these can be used in the templates.
     * 
     * @param string $path The absolute path to the delegate extensions.
     */
    public function addExtensionsPath($path) {
        //$this->delegate->addPluginsDir($path);
    }

    public function pick(array $views) {
        foreach ($views as $view) {
            if (file_exists("$view.php")) {
                return $this->display($view);
            }
        }

        throw new TemplateNotFoundException(implode(" or ", $views));
    }

    public function getFileExtension() {
        return ".php";
    }

}

?>
