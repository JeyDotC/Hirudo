<?php

namespace Hirudo\Impl\Joomla\V15;

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
        if(!$external){
            \JHTML::_("stylesheet", $this->resolveLocalPath($cssPath), "components/$this->componentName/");
        }else{
            \JHTML::_("stylesheet", "", $cssPath);
        }
        return "";
    }

    public function addJavaScript($jsPath, $external = false) {
        if(!$external){
            \JHTML::_("script", $this->resolveLocalPath($jsPath), "components/$this->componentName/");
        }else{
            \JHTML::_("script", "", $jsPath);
        }
        return "";
    }

}

?>
