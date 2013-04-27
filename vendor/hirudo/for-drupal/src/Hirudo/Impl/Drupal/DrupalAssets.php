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

    private static $appRegistry = array();

    public static function registerApp($appName, $module, $src) {
        self::$appRegistry[$appName] = array(
            "module" => $module,
            "src" => $src
        );
    }

    public function addCSS($cssPath, $external = false) {
        if (!$external) {
            \drupal_add_css($this->resolveLocalPath($cssPath), "file");
        } else {
            \drupal_add_css($cssPath, "file");
        }
        return "";
    }

    public function addJavaScript($jsPath, $external = false) {
        if (!$external) {
            \drupal_add_js($this->resolveLocalPath($jsPath), "file");
        } else {
            \drupal_add_js($jsPath, "file");
        }
        return "";
    }

    protected function resolveLocalPath($path) {
        $result = $path;

        if (strpos($path, "::") !== false) {
            $parts = explode("::", $path);
            $appName = $parts[0];
            $asset = $parts[1];
            
            $registry = self::$appRegistry[$appName];
            
            $base = trim(str_replace("::", "/", $registry["src"]), "/");
            
            $result = \drupal_get_path("module", $registry["module"]) . "/$base/$appName/assets/$asset";
        } else {
            $result = "assets/$result";
        }

        return $result;
    }

}

?>
