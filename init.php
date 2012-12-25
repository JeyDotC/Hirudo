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
require_once HIRUDO_ROOT . DS . "framework" . DS . "hirudo" . DS . "Hirudo" . DS . "Lang" . DS . "Enum.php";

use Hirudo\Lang\Loader;

Loader::Init(HIRUDO_ROOT);

//Include the UniversalClassLoader.php file if necesary.
if (!class_exists("Symfony\Component\ClassLoader\UniversalClassLoader")) {
    Loader::using(array(
        "framework::libs::symfony-components::Symfony::Component::ClassLoader::UniversalClassLoader",
    ));
}

//Instantiate the autoloader, create the apc version if APC is available.
if (extension_loaded('apc') && ini_get('apc.enabled')) {
    if (!class_exists("Symfony\Component\ClassLoader\ApcUniversalClassLoader")) {
        Loader::using(array(
            "framework::libs::symfony-components::Symfony::Component::ClassLoader::ApcUniversalClassLoader",
        ));
    }
    $loader = new Symfony\Component\ClassLoader\ApcUniversalClassLoader("hirudo");
} else {
    $loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
}

//Using AnnotationRegistry seems useless for some reason :/
use Doctrine\Common\Annotations\AnnotationRegistry;

$loader->registerNamespaces(array(
    "Hirudo" => Loader::toSinglePath("framework::hirudo", ""),
    "Symfony\Component" => Loader::toSinglePath("framework::libs::symfony-components", ""),
    "Doctrine\Common" => Loader::toSinglePath("framework::libs::doctrine-common", ""),
));

$loader->register();

AnnotationRegistry::registerLoader(array($loader, "loadClass"));
Hirudo\Core\ModulesManager::setAutoLoader($loader);
?>
