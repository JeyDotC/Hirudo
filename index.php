<?php

require_once 'init.php';

use Doctrine\Common\Annotations\AnnotationReader;
use Hirudo\Core\Annotations\Export;
use Hirudo\Core\Annotations\Import;

class MyTestClass {

    /**
     *
     * @var type 
     * @Import(id="X")
     */
    public $property;

}

/**
 * 
 * @Export(id="X") 
 */
class MyExporterTestClass {

    /**
     *
     * @var type 
     * @Import(id="Y")
     */
    function foo() {
        echo "Foo";
    }

}

$myExporterTestClass = new MyExporterTestClass();
$reflected = new ReflectionClass($myExporterTestClass);

$annotationReader = new AnnotationReader();

$annotations = $annotationReader->getClassAnnotations($reflected);
$annotations2 = $annotationReader->getMethodAnnotations($reflected->getMethod("foo"));
//TODO: [debug] Borrar esta linea.
var_dump($annotations);
var_dump($annotations2);
?>
