<?php

namespace Hirudo\Impl\Joomla\V30;

use Hirudo\Core\Context\Assets;
use Hirudo\Core\Annotations\Export;

/**
 * Description of JoomlaAssets
 *
 * @author JeyDotC
 * @Export(id="assets")
 */
class JoomlaAssets extends Assets {

    private $componentName;

    function __construct() {
        $componentName = JoomlaHelper::getMainframe()->scope;
        $this->componentName = $componentName;
    }

    public function addCSS($cssPath, $external = false) {
        if (!$external) {
            \JHtml::stylesheet("components/$this->componentName/{$this->resolveLocalPath($cssPath)}");
        }else{
            \JHtml::stylesheet($cssPath);
        }
        return "";
    }

    public function addJavaScript($jsPath, $external = false) {
        if (!$external) {
            \JHtml::script("components/$this->componentName/{$this->resolveLocalPath($jsPath)}");
        }else{
            \JHtml::script($jsPath);
        }
        return "";
    }

}

?>
