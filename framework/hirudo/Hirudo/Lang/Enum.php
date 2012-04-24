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

/**
 * 
 */
abstract class PseudoEnum {

    public static function valueBelongs($value) {
        $reflector = self::getClass();
        $belongs = $reflector->hasConstant($value);

        return $belongs;
    }

    public static function valueToString($value) {
        $reflector = self::getClass();
        $string = array_search($value, $reflector->getConstants());

        return $string;
    }

    public static function stringToValue($string) {
        $reflector = self::getClass();
        $value = $reflector->getConstant($string);
        return $value;
    }

    /**
     * Gets an array with all the constants of the enum.
     * 
     * @return array An asociative array which keys are the name and values are 
     * the values of all this class's constants.
     */
    public static function values() {
        $reflector = self::getClass();
        $values = $reflector->getConstants();

        return $values;
    }

    private static function getClass() {
        $reflector = new ReflectionClass(get_called_class());
        return $reflector;
    }

}

?>
