<?php

require_once 'init.php';

use Doctrine\Common\Annotations\AnnotationReader;
use Hirudo\Core\Annotations\Export as Export;
use Hirudo\Core\Annotations\Import as Import;
use Hirudo\Libs\Lang\Loader as Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder as ContainerBuilder;

function registerImpl($classes) {
    $containerBuilder = new ContainerBuilder();
    $annotationReader = new AnnotationReader();

//    $autoloader = new Symfony\Component\ClassLoader\MapClassLoader($classes);
//    $autoloader->register();

    foreach ($classes as $class => $path) {
        Loader::using($path);
        /* @var $annotation Export */
        $annotation = $annotationReader->getClassAnnotation(new ReflectionClass($class), "Hirudo\Core\Annotations\Export");
        $definition = $containerBuilder->register($annotation->id, $class);
        if (!empty($annotation->factory)) {
            $definition->setFactoryClass($class)->setFactoryMethod($annotation->factory);
        }
    }
}

\registerImpl(array(
    //The request data.
    'Hirudo\Libs\Impl\StandAlone\SARequest' => "framework::libs::Impl::StandAlone::SARequest",
    //The URL builder.
    'Hirudo\Libs\Impl\StandAlone\SARouting' => "framework::libs::Impl::StandAlone::SARouting",
    //The session Manager.
    'Hirudo\Libs\Impl\StandAlone\SASession' => "framework::libs::Impl::StandAlone::SASession",
    //The current user.
    'Hirudo\Libs\Impl\StandAlone\SAPrincipal' => "framework::libs::Impl::StandAlone::SAPrincipal",
    //The configuration manager.
    'Hirudo\Libs\Impl\StandAlone\SAppConfig' => "framework::libs::Impl::StandAlone::SAppConfig",
    //The templating system.
    'Hirudo\Libs\Impl\Common\Templating\SmartyTemplating' => "framework::libs::Impl::Common::Templating::SmartyTemplating",
));
?>
