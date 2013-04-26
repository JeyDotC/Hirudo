<?php

namespace Hirudo\Lang;

/**
 * This class represents an array with a limited set of key-value pairs which
 * can be considered as an enum.
 * 
 * @author JeyDotC
 */
interface ArrayEnumInterface {

    /**
     * Gets the list of values for this enum.
     * 
     * @return array A map where the keys are the names and values are the values of the enum.
     */
    static function values();

    /**
     * Tells if there is a value for the given key.
     * 
     * @param string $key
     * @return boolean True if there is a value for that key, false otherwise.
     */
    static function hasValue($key);

    /**
     * 
     * @param type $value
     * @todo This API function name is incorrect, rename to 'getValue'.
     * 
     */
    static function fromValue($value);
}

?>
