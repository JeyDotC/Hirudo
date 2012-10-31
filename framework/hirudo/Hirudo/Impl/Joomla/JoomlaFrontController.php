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

namespace Hirudo\Impl\Joomla;

use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\ModulesManager;

defined('_JEXEC') or die('Restricted access');

require_once "JoomlaHelper.php";

function joomlaAutoloader($class) {
    if (\JLoader::load($class)) {
        return true;
    }
    return false;
}

/**
 * A fix for joomla autoloader, joomla took the wrong decision of overriding
 * the __autoload function instead of registering one via the spl_autoload_register
 * function.
 */
spl_autoload_register("Hirudo\Impl\Joomla\joomlaAutoloader");

jimport('joomla.application.component.controller');

/**
 * The underscore front controller implementation for joomla.
 *
 * @author Virtualidad
 */
class JoomlaFrontController extends \JController {

    /**
     *
     * @var \JView
     */
    private $view;
    private $manager;

    /**
     * Constructs this controller as a joomla controller.
     */
    public function __construct(ModulesManager $manager) {
        //As this is not at a tipical component is necesary to say where are we.
        parent::__construct(array("base_path" => __DIR__));
        parent::registerDefaultTask("doTask");

        $this->manager = $manager;

        $document = &\JFactory::getDocument();
        //Get the view saying where is it.
        $this->view = &$this->getView('_', $document->getType(), '', array("base_path" => __DIR__));
    }

    /**
     * Executes the task taken from request data and orders the view to display.
     */
    public function doTask() {

        $html = $this->manager->run();

        if (isset($html)) {
            $this->view->assignRef("html", $html);
            $this->view->display();
        }
    }

    /**
     * Executes a task 
     * 
     * @param string $task
     * @return mixed 
     */
    public function execute($task) {
        $isAjax = ModulesContext::instance()->getRequest()->isAjax();

        $mainframe = JoomlaHelper::getMainframe();
        $return = parent::execute($task);

        if ($isAjax) {
            $mainframe->close();
        }

        return $return;
    }

    public function run() {
        $this->execute("");
        $this->redirect();
    }

}

?>
