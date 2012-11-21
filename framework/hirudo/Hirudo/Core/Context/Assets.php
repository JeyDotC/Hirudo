<?php

/**
 * «Copyright 2012 Jeysson José Guevara Mendivil(JeyDotC)» 
 * 
 * This file is part of Hirudo.
 * 
 * Hirudo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 *  Hirudo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 * 
 *  You should have received a copy of the GNU General Public License
 *  along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Core\Context;

/**
 * <p>This class creates the script and link tags.</p>
 * 
 * <p><strong>Note:</strong> The entire tag is created instead of just adjusting
 * the path to the asset. This is because adjusting the path is not enough in
 * some CMS, like Joomla.</p>
 *
 * @author JeyDotC
 */
abstract class Assets {

    /**
     * <p>Creates a script tag. Depending on the CMS it will may automatically insert
     * the tag using the CMS assets system or simply returns a string representing
     * the tag.</p>
     * 
     * @param string $jsPath The path to a JavaScript file. The path is as if
     * the current directory were the assets/ folder, thus, if the javascript file is
     * at <code>MyHirudoProject/assets/js/Path/To/MyScript.js</code> the jsPath should be 
     * <code>js/Path/To/MyScript.js</code>.
     * 
     * @param boolean $external Is the script external to the application? in such case the path is considered absolute.
     * 
     * @return string The script tag.
     */
    public abstract function addJavaScript($jsPath, $external = false);

    /**
     * <p>Creates a link tag. Depending on the CMS it will may automatically insert
     * the tag using the CMS assets system or simply returns a string representing
     * the tag.</p>
     * 
     * @param string $cssPath The path to a CSS file. The path is as if
     * the current directory were the assets/ folder, thus, if the CSS file is
     * at <code>MyHirudoProject/assets/css/Path/To/MyCSS.css</code> the cssPath should be 
     * <code>css/Path/To/MyCSS.css</code>.
     * 
     * @param boolean $external Is the css external to the application? in such case the path is considered absolute.
     * 
     * @return string The link tag.
     */
    public abstract function addCSS($cssPath, $external = false);

    /**
     * This helper function generates a script tag which src attribute will
     * be set to the given path. Note that the jsPath must be already adjusted
     * to meet the CMS conventions.
     * 
     * @param string $jsPath A path to a javascript file.
     * @return string The script tag. 
     */
    protected function generateScriptTag($jsPath) {
        return "<script type='text/JavaScript' src='$jsPath'></script>";
    }

    /**
     * This helper function generates a link tag which src attribute will
     * be set to the given path. Note that the cssPath must be already adjusted
     * to meet the CMS conventions.
     * 
     * @param string $cssPath A path to a CSS file.
     * @return string The link tag. 
     */
    protected function generateCSSTag($cssPath) {
        return "<link type='text/css' rel='stylesheet' href='$cssPath' />";
    }

    protected function resolveLocalPath($path) {
        $result = $path;

        if (strpos($path, "::") !== false) {
            $parts = explode("::", $path);
            $src = ModulesContext::instance()->getConfig()->get("businessRoot", "src");
            $base = trim(str_replace("::", "/", $src), "/");
            $result = "$base/$parts[0]/assets/$parts[1]";
        } else {
            $result = "assets/$result";
        }

        return $result;
    }

}

?>
