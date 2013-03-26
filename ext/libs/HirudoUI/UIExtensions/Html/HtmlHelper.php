<?php

namespace UIExtensions\Html;

use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\TemplatingInterface;
use ReflectionClass;

/**
 * A set of functions to help in html rendering.
 * 
 * @author JeyDotC
 */
class HtmlHelper {

    /**
     *
     * @var TemplatingInterface
     */
    private $view;
    private $assetsPath;

    /**
     * Creates a new HtmlHelper
     * 
     * @param \Hirudo\Core\TemplatingInterface $templating
     * @param type $assetsPath The path to the user-defined templates.
     */
    function __construct(TemplatingInterface $templating, $assetsPath) {
        $this->view = $templating;
        $this->assetsPath = $assetsPath;
    }

    /**
     * Renders an editor for a property of the given object.
     * 
     * @param mixed $for The object which field will be rendered.
     * @param string $at The name of the property to be represented.
     * @param string $root A root name for the property
     * @return string The html representation of the field.
     */
    public function editor($for, $at, $root="") {
        return $this->callTemplate($for, $at, $root, "editors");
    }

    /**
     * Renders a display for a property of the given object.
     * 
     * @param mixed $for The object which field will be rendered.
     * @param string $at The name of the property to be represented.
     * @param string $root A root name for the property
     * @return string The html representation of the field.
     */
    public function display($for, $at, $root="") {
        return $this->callTemplate($for, $at, $root, "displays");
    }

    /**
     * Gets a grid object which usually represents the given collection as an html
     * table.
     * 
     * @param array $dataSource The data to be rendered.
     * 
     * @return \UIExtensions\Html\Grid\Grid The grid object that will represent the collection.
     */
    public function grid($dataSource) {
        return new Grid\Grid($dataSource);
    }

    public function callTemplate($for, $at, $root, $type) {
        if(empty($root)){
            $root = lcfirst(get_class($root));
        }
        $propertyData = $this->loadContext($for, $at, $root);
        $template = $propertyData->getPropertyType();
        $uiHint = $propertyData->getMetadataById("UIExtensions\Annotations\UIHint");
        if ($uiHint != null) {
            $template = $uiHint->template;
        }
        $this->view->assign("propertyData", $propertyData);
        $this->view->assign("uiHint", $uiHint);

        $userTemplates = array(
            "requested" => $this->assetsPath . DS . $type . DS . $template,
            "default" => $this->assetsPath . DS . $type . DS . "mixed"
        );

        $defaultTemplates = array(
            "requested" => dirname(__FILE__) . DS . "default_templates" . DS . $type . DS . "$template",
            "default" => dirname(__FILE__) . DS . "default_templates" . DS . $type . DS . "mixed"
        );

        if (file_exists($userTemplates["requested"] . $this->view->getFileExtension())) {
            return $this->view->display($userTemplates["requested"]);
        } else if (file_exists($userTemplates["default"] . $this->view->getFileExtension())) {
            return $this->view->display($userTemplates["default"]);
        } else if (file_exists($defaultTemplates["requested"] . ".php")) {
            return include $defaultTemplates["requested"] . ".php";
        } else {
            return include $defaultTemplates["default"] . ".php";
        }
    }

    private function loadContext($for, $at, $root) {
        $reflection = new ReflectionClass($for);
        $value = $for;
        $propertyPath = explode(".", $at);

        foreach ($propertyPath as $propertyName) {
            $property = $reflection->getProperty($propertyName);
            if ($property->isPrivate()) {
                $value = $reflection->getMethod("get" . ucfirst($property->name))->invoke($value);
            } else {
                $value = $property->getValue($value);
            }
            if (is_object($value)) {
                $reflection = new ReflectionClass($value);
            }
        }

        $editorContext = new EditorContext($property, $value, $at, $root);
        return $editorContext;
    }

}

?>
