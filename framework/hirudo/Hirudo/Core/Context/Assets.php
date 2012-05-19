<?php

namespace Hirudo\Core\Context;

/**
 * Description of Assets
 *
 * @author JeyDotC
 */
abstract class Assets {

    public abstract function addJavaScript($jsPath);
    public abstract function addCSS($cssPath);
    
    protected function generateScriptTag($jsPath) {
        return "<script type='text/JavaScript' src='$jsPath'></script>";
    }
    
    protected function generateCSSTag($cssPath) {
        return "<link type='text/css' rel='stylesheet' href='$cssPath' />";
    }
}

?>
