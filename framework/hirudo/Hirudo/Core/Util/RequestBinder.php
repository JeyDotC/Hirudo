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

namespace Hirudo\Core\Util;

use Hirudo\Serialization\ArrayToEntityConverter;
use Hirudo\Core\Context\ModulesContext;

/**
 *
 * @author JeyDotC
 * @unused
 */
class RequestBinder {

    private $converter;

    function __construct() {
        $this->converter = new ArrayToEntityConverter();
    }

    public function bind(&$object, $bindings = null) {
        $request = ModulesContext::instance()->getRequest();

        if (!is_array($bindings)) {
            $bindings = $request->post("__bindings");
        }

        $this->converter->convert($bindings, $object);
    }

}

?>
