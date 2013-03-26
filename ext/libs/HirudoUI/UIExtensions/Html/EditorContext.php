<?php

namespace UIExtensions\Html;

use Hirudo\Core\Context\ModulesContext;
use ReflectionProperty;

/**
 * This class holds information about the field that is being
 * represented.
 *
 * @author JeyDotC
 */
class EditorContext {

    /**
     *
     * @var ReflectionProperty
     */
    private $reflectionProperty;
    private $value;
    private $accessor;
    private $name;
    private $root;
    private $propertyType;

    private $metadataReader;

    /**
     * Creates a new EditorsContext.
     * 
     * @param ReflectionProperty $reflectionProperty Data about the property being represented.
     * @param mixed $value The current value of the property
     * @param string $accessor 
     * @param string $root A root name for the property
     */
    function __construct(ReflectionProperty $reflectionProperty, $value, $accessor, $root) {
        $this->reflectionProperty = $reflectionProperty;
        $this->value = $value;
        $this->accessor = $accessor;
        $this->root = $root;
        $this->name = $this->accessorAsName();
        $this->propertyType = Util::getTypeFromDocComment($this->reflectionProperty->getDocComment());
        $this->metadataReader = ModulesContext::instance()->getDependenciesManager();
    }

    /**
     * Gets the reflection object of this field.
     * 
     * @return ReflectionProperty
     */
    public function getReflectionProperty() {
        return $this->reflectionProperty;
    }

    /**
     * Gets the value of this field.
     * 
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Gets the string used to access this field.
     * 
     * @return string
     */
    public function getAccessor() {
        return $this->accessor;
    }

    /**
     * Gets the name of the field represented as an html name.
     * 
     * @return string The name of the field ready to be used in the html name attribute.
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Gets the name of the type that this property holds, based on the doccoment
     * of the property.
     * 
     * @return string
     */
    public function getPropertyType() {
        return $this->propertyType;
    }

    /**
     * Gets all the annotations associated to the current property.
     * 
     * @return array
     */
    public function getMetadata() {
        return $this->metadataReader->getPropertyMetadata($this->reflectionProperty);
    }

    /**
     * Gets the annotation of the given class associated to the current property.
     * 
     * @param string $id The annotation class.
     * @return mixed The requested annotation or null if not present on the property.
     */
    public function getMetadataById($id) {
        return $this->metadataReader->getPropertyMetadataById($this->reflectionProperty, $id);
    }

    /**
     * Gets the text corresponding to the control label.
     * 
     * @return string The label text.
     */
    function getDisplayName() {
        $displayName = $this->reflectionProperty->name;

        $annotation = $this->getMetadataById("UIExtensions\Annotations\DisplayName");
        if ($annotation instanceof Annotations\DisplayName) {
            $displayName = $annotation->name;
        }

        return $displayName;
    }

    private function accessorAsName() {
        $route = explode(".", "$this->root.$this->accessor");
        $name = array_shift($route);

        foreach ($route as $key) {
            $index = "";
            $bracketPosition = strpos($key, "[");

            if ($bracketPosition !== false) {
                $index = substr($key, $bracketPosition);
                $key = substr($key, 0, $bracketPosition);
            }

            $name .= "[$key]$index";
        }

        return $name;
    }
}

?>
