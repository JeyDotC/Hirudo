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


// TODO: Remove or wrap this class
require_once 'ChromePhp.php';

if (!defined("DS")) {
    define("DS", DIRECTORY_SEPARATOR);
}

if (!defined("HIRUDO_ROOT")) {
    define("HIRUDO_ROOT", dirname(__FILE__));
}

//A file loader helper.
require_once HIRUDO_ROOT . DS . "framework" . DS . "hirudo" . DS . "Hirudo" . DS . "Lang" . DS . "Loader.php";

use Hirudo\Lang\Loader;

Loader::Config(HIRUDO_ROOT, DS);
//Load some useful classes.
Loader::using(array(
    "framework::libs::symfony-components::Symfony::Component::ClassLoader::UniversalClassLoader",
    "framework::libs::doctrine-common::Doctrine::Common::Annotations::AnnotationRegistry",
    "framework::hirudo::Hirudo::Lang::Enum",
));

use Symfony\Component\ClassLoader\UniversalClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry as AnnotationRegistry;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    "Hirudo" => Loader::toSinglePath("framework::hirudo", ""),
    "Symfony\\Component" => Loader::toSinglePath("framework::libs::symfony-components", ""),
    "Doctrine\\Common" => Loader::toSinglePath("framework::libs::doctrine-common", ""),
));
AnnotationRegistry::registerLoader(array($loader, "loadClass"));
AnnotationRegistry::registerAutoloadNamespace("Hirudo\Core\Annotations", Loader::toSinglePath("framework::hirudo::Hirudo::Core::Annotations", ""));
$loader->register();
Hirudo\Core\ModulesManager::setAutoLoader($loader);
?>
