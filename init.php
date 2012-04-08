<?php

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
