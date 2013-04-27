<?php

namespace Hirudo\Impl\Moodle;

use Hirudo\Core\Context\Assets;
use Hirudo\Core\Annotations\Export;

/**
 * Description of Moodlessets
 *
 * @author JeyDotC
 * @Export(id="assets")
 */
class MoodleAssets extends Assets {

    public function addCSS($cssPath, $external = false) {
        global $PAGE;
        global $CFG;

        if (!$external) {
            $PAGE->requires->css("/{$CFG->hirudo_module_location}/{$this->resolveLocalPath($cssPath)}");
        } else {
            $PAGE->requires->css($cssPath);
        }

        return "";
    }

    public function addJavaScript($jsPath, $external = false) {
        global $PAGE;
        global $CFG;

        if (!$external) {
            $PAGE->requires->js("/{$CFG->hirudo_module_location}/{$this->resolveLocalPath($jsPath)}");
        } else {
            $PAGE->requires->js($jsPath);
        }
        return "";
    }

}

?>
