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
if (!defined("DS")) {
    define("DS", DIRECTORY_SEPARATOR);
}

if (!defined("HIRUDO_ROOT")) {
    define("HIRUDO_ROOT", dirname(__FILE__));
}

/* @var $composerLoader Composer\Autoload\ClassLoader */
$composerLoader = require_once HIRUDO_ROOT . "/vendor/autoload.php";

use Hirudo\Lang\Loader;

Loader::Init(HIRUDO_ROOT);

//Instantiate the autoloader, create the apc version if APC is available.
if (extension_loaded('apc') && ini_get('apc.enabled')) {
    $loader = new Symfony\Component\ClassLoader\ApcClassLoader("hirudo", $composerLoader);
} else {
    $loader = new \Symfony\Component\ClassLoader\UniversalClassLoader();
}

//Using AnnotationRegistry seems useless for some reason :/
use Doctrine\Common\Annotations\AnnotationRegistry;

$loader->register();

AnnotationRegistry::registerLoader(array($loader, "loadClass"));
AnnotationRegistry::registerLoader(array($composerLoader, "loadClass"));

Hirudo\Core\ModulesManager::setAutoLoader($loader);
?>
