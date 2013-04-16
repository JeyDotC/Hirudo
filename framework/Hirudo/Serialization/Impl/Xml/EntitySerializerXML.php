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

namespace Hirudo\Serialization\Impl\Xml;

use Hirudo\Serialization\EntitySerializerBase;

/**
 * JSON implementation of EntitySerializerBase. Converts the given object
 * into a JSON string.
 * 
 * @author JeyDotC
 */
class EntitySerializerXML extends EntitySerializerBase {

    protected function doSerialize($array) {
        return '<?xml version="1.0"?>' . $this->_doSerialize("root", $array);
    }

    private function _doSerialize($root, $array) {
        if (!is_array($array)) {
            return "<$root>
                        $array
                    </$root>";
        }

        $result = "";

        foreach ($array as $key => $value) {
            if(is_numeric($key)){
                $key = $root;
            }
            $result .= $this->_doSerialize($key, $value);
        }

        return "<$root>
                    $result
                </$root>";
    }

}

?>
