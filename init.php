<?php

if (!defined("DS")) {
    define("DS", DIRECTORY_SEPARATOR);
}

if (!defined("HIRUDO_ROOT")) {
    define("HIRUDO_ROOT", dirname(__FILE__));
}

if (!defined("HIRUDO_LIBS_DIR")) {
    define("HIRUDO_LIBS_DIR", HIRUDO_ROOT . DS . 'framework' . DS . 'libs');
}

//A file loader helper.
require_once HIRUDO_LIBS_DIR . DS . "Lang" . DS . "Loader.php";

use Hirudo\Libs\Lang\Loader as Loader;

Loader::Config(HIRUDO_ROOT, DS);
//Load some useful classes.
Loader::using(array(
    "framework::libs::symfony-components::Symfony::Component::ClassLoader::UniversalClassLoader",
    "framework::hirudo::Hirudo::Lang::Enum",
));

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();

$loader->registerNamespaces(array(
    "Hirudo" => Loader::toSinglePath("framework::hirudo", ""),
    "Symfony\\Component" => Loader::toSinglePath("framework::libs::symfony-components", ""),
    "Doctrine\\Common" => Loader::toSinglePath("framework::libs::doctrine-common", ""),
));

// TODO: Fix the autoloader configuration to make this unnecesary.
Loader::using("framework::Hirudo::Core::Annotations::*");

$loader->register();
?>
