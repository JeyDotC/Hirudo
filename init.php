<?php

if (!defined("DS")) {
    define("DS", DIRECTORY_SEPARATOR);
}

if (!defined("HIRUDO_ROOT")) {
    define("HIRUDO_ROOT", dirname(__FILE__));
}

if (!defined("HIRUDO_LIBS_DIR")) {
    define("HIRUDO_LIBS_DIR", HIRUDO_ROOT . DS . 'Hirudo' . DS . 'libs');
}

//A file loader helper.
require_once HIRUDO_LIBS_DIR . DS . "Lang" . DS . "Loader.php";

use Hirudo\Libs\Lang\Loader as Loader;

Loader::Config(HIRUDO_ROOT, DS);
//Load some useful classes.
Loader::using(array(
    "libs::ClassLoader::UniversalClassLoader",
    "libs::Lang::Enum",
    "underscore::libs::smarty::Smarty.class",
));

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();

$loader->registerNamespaces(array(
    "Symfony\Component" => Loader::toSinglePath("libs::Symfony::Component", ""),
    "Doctrine\Common" => Loader::toSinglePath("libs::Doctrine::Common", ""),
    "Hirudo\Core" => Loader::toSinglePath("hirudo::Core", ""),
    "Hirudo\Libs" => Loader::toSinglePath("libs", "")
));

$loader->useIncludePath(true);

$loader->register();
?>
