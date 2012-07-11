<?php

namespace Hirudo\Impl\StandAlone;

use Hirudo\Core\Context\Assets;
use Hirudo\Core\Annotations\Export;

/**
 * Description of SAssets
 *
 * @author JeyDotC
 * @Export(id="assets")
 */
class SAssets extends Assets {

    public function addCSS($cssPath) {
        return $this->generateCSSTag("./{$this->resolveLocalPath($cssPath)}");
    }

    public function addJavaScript($jsPath) {
        return $this->generateScriptTag("./{$this->resolveLocalPath($jsPath)}");
    }

}

?>
