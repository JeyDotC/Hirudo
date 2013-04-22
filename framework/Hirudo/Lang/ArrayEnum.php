<?php

namespace Hirudo\Lang;

/**
 * Base class for arrayEnums.
 *
 * @author JeyDotC
 */
abstract class ArrayEnum implements ArrayEnumInterface {

    public static function hasValue($value) {
        $called = get_called_class();
        return array_key_exists($value, $called::values());
    }

    public static function fromValue($value) {
        $called = get_called_class();
        $values = $called::values();
        return $values[$value];
    }

}

?>
