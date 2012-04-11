<?php

defined('_JEXEC') or die('Restricted access');
require_once 'init.php';

use Hirudo\Impl\Joomla\JoomlaFrontController;
use Hirudo\Core\ModulesManager;

$controller = new JoomlaFrontController(new ModulesManager(array(
                    //The request data.
                    "Hirudo\Impl\Joomla\JoomlaRequest",
                    //The URL builder.
                    "\Hirudo\Impl\Joomla\JoomlaRouting",
                    //The session Manager.
                    "Hirudo\Impl\Joomla\JoomlaSession",
                    //The current user.
                    "Hirudo\Impl\Joomla\JoomlaPrincipal",
                    //The configuration manager.
                    'Hirudo\Impl\StandAlone\SAppConfig',
                    //The templating system.
                    'Hirudo\Impl\Common\Templating\SmartyTemplating',
                )));

$controller->run();
?>
