<?php

namespace Hirudo\Lang;

/**
 *
 * @author JeyDotC
 */
interface ArrayEnumInterface {
    
    static function values();
    static function hasValue($value);
    static function fromValue($value);
}

?>
