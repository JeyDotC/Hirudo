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

namespace Hirudo\Impl\Drupal;

use Hirudo\Core\ModulesManager;

/**
 * The underscore front controller implementation for joomla.
 *
 * @author Virtualidad
 */
class DrupalFrontController extends ModulesManager {

    private static $implementationClasses = array();
    private static $instance;

    public static function setImplementationClasses(array $classes) {
        self::$implementationClasses = $classes;
    }

    public static function setupBlock() {
        return array(
            "hirudo" => array(
                "info" => "Hirudo framework",
                'cache' => DRUPAL_NO_CACHE,
            )
        );
    }

    public static function setupMenu() {
        $menu = array();
        $menu["App"] = array(
            "page callback" => "hirudo6_run",
            "access callback" => true,
        );
        return $menu;
    }

    /**
     * 
     * @return DrupalFrontController
     */
    public static function instance() {
        if (!self::$instance) {
            self::$instance = new DrupalFrontController();
        }

        return self::$instance;
    }

    public function blockView($delta = "") {
        $block = array();

        if ($delta == "hirudo") {
            $block = array(
                "subject" => "<none>",
                "content" => $this->run()
            );
        }

        return $block;
    }
    
    public function __construct() {
        parent::__construct(self::$implementationClasses);
    }

}

?>
