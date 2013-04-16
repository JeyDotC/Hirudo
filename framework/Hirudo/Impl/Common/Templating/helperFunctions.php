<?php

/**
 * This function is intended to be used in a template to create new instances of
 * objects.
 * 
 * Usage: {$value = new_("My\Class", $param1, "Another param")}
 * 
 * @param string $className The class to be instantiated.
 * @param mixed $_ Constructor parameters.
 * 
 * @return mixed
 */
function new_($className) {
    $params = func_get_args();
    $className = array_shift($params);
    $reflection = new \ReflectionClass($className);
    return $reflection->newInstanceArgs($params);
}

/**
 * Represents a ternary operator.
 * 
 * Usage: {$value = if_($myCondition == true, "A value", "else value which is optional.")}
 * 
 * @param boolean $condition the condition to be tested.
 * @param mixed $isTrue The value returned if true.
 * @param mixed $isFalse The value returned if false.
 * 
 * @return mixed
 */
function if_($condition, $isTrue, $isFalse = null) {
    return $condition ? $isTrue : $isFalse;
}

?>
