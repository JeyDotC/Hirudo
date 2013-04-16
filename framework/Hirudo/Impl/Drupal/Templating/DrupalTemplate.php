<?php

namespace Hirudo\Impl\Drupal\Templating;

/**
 * Description of DrupalTemplate
 *
 * @author JeyDotC
 */
class DrupalTemplate {

    private static $instances = array();
    private $___data = array();

    /**
     * 
     * @return array
     */
    protected function render() {
        return array();
    }

    public function fetch($file) {
        $template = $this->load($file, $this->___data);
        $renderableArray = $template->render();
        $this->___data = array();

        return drupal_render($renderableArray);
    }

    public function display($file) {
        echo $this->fetch($file);
    }

    protected function include_template($file) {
        return $this->load($file, $this->___data)->render();
    }

    public function assign($key, $value) {
        $this->___data[$key] = $value;
    }

    /**
     * 
     * @param type $file
     * @return \Hirudo\Impl\Drupal\Templating\DrupalTemplate
     */
    private function load($file, array $data) {
        if (!array_key_exists($file, self::$instances)) {
            require_once $file;
            $parts = explode(".", basename($file));
            $classname = $parts[0];
            
            if (!(is_a($classname, "Hirudo\Impl\Drupal\Templating\DrupalTemplate", true))) {
                throw new Exception("The class '$classname' must extend \Hirudo\Impl\Drupal\Templating\DrupalTemplate");
            }
            
            self::$instances[$file] = new $classname();
        }
        
        $template = self::$instances[$file];
        
        foreach ($data as $key => $value) {
            $template->{$key} = $value;
        }

        return $template;
    }

}

?>
