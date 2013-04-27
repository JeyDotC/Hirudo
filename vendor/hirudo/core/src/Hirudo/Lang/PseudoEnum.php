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

namespace Hirudo\Lang;

/**
 * <p>A base class for simple Enum representation. It gives some utility methods
 * commonly associated to the enums in other languages.</p>
 * 
 * <p>To make an enum class just extend this class and add the enum constants, like this:
 * 
 * <code>
 * class MyEnum extends PseudoEnum {
 *      const AN_ENUM_VALUE = 0;
 *      const OTHER_ENUM_VALUE = 1;
 *      const AND_OTHER_ENUM_VALUE = 2;
 * }
 * </code></p>
 * 
 */
abstract class PseudoEnum {

    /**
     * Says if the given value belongs to the set of values  of this enum.
     * 
     * @param string|number $value The value which we want to know if exists for this enum.
     * @return boolean True if the value exists for this enum, false otherwise.
     */
    public static function valueBelongs($value) {
        $reflector = self::getClass();
        $constants = $reflector->getConstants();

        return in_array($value, $constants);
    }

    /**
     * Says if there is a constant with the given name for this enum.
     * 
     * @param string|number $value The name which we want to know if exists for this enum.
     * @return boolean True if the name exists for this enum, false otherwise.
     */
    public static function nameBelongs($name) {
        $reflector = self::getClass();
        $belongs = $reflector->hasConstant($name);

        return $belongs;
    }

    /**
     * Returns the constant name corresponding to the given value.
     * 
     * @param string|number $value The value which we want to know name in the enum list.
     * @return string The name corresponding to the given value. 
     */
    public static function valueToString($value) {
        $reflector = self::getClass();
        $string = array_search($value, $reflector->getConstants());

        return $string;
    }

    /**
     * Returns a value by the corresponding name.
     * 
     * @param string $string The name of the constant.
     * @return string|number The value corresponding to the constant with the given name.
     */
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
