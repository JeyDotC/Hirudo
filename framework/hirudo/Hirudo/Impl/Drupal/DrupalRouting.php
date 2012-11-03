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

namespace Hirudo\Impl\Drupal;

use Hirudo\Core\Annotations\Export;
use Hirudo\Core\Context\Routing as Routing;

/**
 * @Export(id="routing")
 */
class DrupalRouting extends Routing {

    public function appAction($app, $module, $task = "index", array $params = array()) {
        return url("App/$app/$module/$task", array("query" => $params));
    }

    public function redirect($url) {
        \drupal_goto($url);
    }

    public function getBaseURL() {
        global $base_url;
        return $base_url;
    }

}

?>
