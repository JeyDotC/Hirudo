<?php

namespace Hirudo\Impl\Joomla;

use Hirudo\Core\Context\Assets;
use Hirudo\Core\Annotations\Export;

/**
 * Description of JoomlaAssets
 *
 * @author JeyDotC
 * @Export(id="assets")
 */
class JoomlaAssets extends Assets {

    private $assetsPath;

    function __construct() {
        $componentName = JoomlaHelper::getMainframe()->scope;
        $this->assetsPath = $componentName;
    }

    public function load($assetPath) {

        return "components/$component/assets/$assetPath";
    }

    public function addCSS($cssPath) {
        JHTML::_("script", $cssPath, $this->componentName);
        return "";
    }

    public function addJavaScript($jsPath) {
        JHTML::_("stylesheet", $jsPath, $this->componentName);
        return "";
    }

}

?>
