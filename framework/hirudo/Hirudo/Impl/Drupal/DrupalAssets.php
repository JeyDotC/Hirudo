<?php

namespace Hirudo\Impl\Drupal;

use Hirudo\Core\Context\Assets;
use Hirudo\Core\Annotations\Export;

/**
 * Description of DrupalAssets
 *
 * @author JeyDotC
 * @Export(id="assets")
 */
class DrupalAssets extends Assets {

    public function addCSS($cssPath) {
        \drupal_add_css(\drupal_get_path("module", HIRUDO_DRUPAL_MODULE) . "/{$this->resolveLocalPath($cssPath)}", "file");
        return "";
    }

    public function addJavaScript($jsPath) {
        \drupal_add_js(\drupal_get_path("module", HIRUDO_DRUPAL_MODULE) . "/{$this->resolveLocalPath($jsPath)}", "file");
        return "";
    }

}

?>
