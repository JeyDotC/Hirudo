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
defined('_JEXEC') or die('Restricted access');
jimport("joomla.version");

require_once 'init.php';

use Hirudo\Core\ModulesManager;

$jversion = new \JVersion();

$V = "V15";

if ($jversion->isCompatible("3")) {
    $V = "V30";
}

$controllerClass = "Hirudo\\Impl\\Joomla\\{$V}\\JoomlaFrontController";
$controller = new $controllerClass(new ModulesManager(array(
                    //The request data.
                    "Hirudo\\Impl\\Joomla\\{$V}\\JoomlaRequest",
                    //The URL builder.
                    "\\Hirudo\\Impl\\Joomla\\{$V}\\JoomlaRouting",
                    //The session Manager.
                    "Hirudo\\Impl\\Joomla\\{$V}\\JoomlaSession",
                    //The current user.
                    "Hirudo\\Impl\\Joomla\\{$V}\\JoomlaPrincipal",
                    //The configuration manager.
                    "Hirudo\\Impl\\StandAlone\\SAppConfig",
                    //The templating system.
                    "Hirudo\\Impl\\Common\\Templating\\SmartyTemplating",
                    //The Sql Model
                    "Hirudo\\Impl\\Joomla\\Models\\Components\\Sql\\JoomlaQueryFactory",
                    //The Asset system
                    "Hirudo\\Impl\\Joomla\\{$V}\\JoomlaAssets",
                )));

$controller->run();
?>