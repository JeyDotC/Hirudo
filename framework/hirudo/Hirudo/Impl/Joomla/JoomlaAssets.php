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

    private $componentName;

    function __construct() {
        $componentName = JoomlaHelper::getMainframe()->scope;
        $this->componentName = $componentName;
    }

    public function addCSS($cssPath) {
        \JHTML::_("stylesheet", $this->resolveLocalPath($cssPath), "components/$this->componentName/");
        return "";
    }

    public function addJavaScript($jsPath) {
        \JHTML::_("script", $this->resolveLocalPath($jsPath), "components/$this->componentName/");
        return "";
    }

}

?>
