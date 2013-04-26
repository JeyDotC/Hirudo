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

    
    
    public function aaddCSS($cssPath) {
        return $this->generateCSSTag("./{$this->resolveLocalPath($cssPath)}");
    }

    public function aaddJavaScript($jsPath) {
        return $this->generateScriptTag("./{$this->resolveLocalPath($jsPath)}");
    }

    public function addCSS($cssPath, $external = false) {
        if(!$external){
            return $this->generateCSSTag("./{$this->resolveLocalPath($cssPath)}");
        }else{
            return $this->generateCSSTag($cssPath);
        }
    }

    public function addJavaScript($jsPath, $external = false) {
        if(!$external){
            return $this->generateScriptTag("./{$this->resolveLocalPath($jsPath)}");
        }else{
            return $this->generateScriptTag($jsPath);
        }
    }

}

?>
