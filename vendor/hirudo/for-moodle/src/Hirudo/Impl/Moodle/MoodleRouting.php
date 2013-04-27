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
 * Hirudo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Impl\Moodle;

use Hirudo\Core\Context\Routing as Routing;

/**
 * 
 * @Hirudo\Core\Annotations\Export(id="routing")
 */
class MoodleRouting extends Routing {

    public function appAction($app, $module, $task = "index", array $params = array()) {
        global $CFG;
        return new \moodle_url("/{$CFG->hirudo_module_location}/view.php", array_merge(array("h" => "$app/$module/$task"), $params));
    }

    public function redirect($url) {
        header("Location: $url");
    }

    public function getBaseURL() {
        global $CFG;
        return $CFG->wwwroot;
    }

}

?>
