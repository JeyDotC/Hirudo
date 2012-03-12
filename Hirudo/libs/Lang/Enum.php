<?php

/**
 * 
 */
abstract class PseudoEnum {

    public static function valueBelongs($value) {
        $reflector = self::getClass();
        $belongs = $reflector->hasConstant($value);
        
        return $belongs;
    }

    public static function valueToString($value){
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
    public static function values(){
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
