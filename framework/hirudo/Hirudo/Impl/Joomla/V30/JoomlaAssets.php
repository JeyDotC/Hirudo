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

    public function addCSS($cssPath) {
        \JHtml::stylesheet("components/$this->componentName/{$this->resolveLocalPath($cssPath)}");
        return "";
    }

    public function addJavaScript($jsPath) {
        \JHtml::script("components/$this->componentName/{$this->resolveLocalPath($jsPath)}");
        return "";
    }

}

?>
