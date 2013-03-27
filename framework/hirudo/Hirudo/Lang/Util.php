<?php

namespace Hirudo\Lang;

/**
 * Utility functions grouped here
 * until I find a better place for them.
 *
 * @author JeyDotC
 */
class Util {

    /**
     * Gets the type given by the var annotation of a doccoment.
     * 
     * @param string $docComment
     * @return string The type name given by the doccoment.
     */
    public static function getTypeFromDocComment($docComment) {
        $commentLines = explode("\n", $docComment);
        $type = "mixed";

        foreach ($commentLines as $commentLine) {
            if (strpos($commentLine, '@var ') !== false) {
                $type = explode(" ", trim($commentLine));
                $type = trim($type[2]);
                break;
            }
        }

        return $type;
    }
    
    public static function pascalCaseSplit($string) {
        return \preg_replace(array('/(?<=[^A-Z])([A-Z])/', '/(?<=[^0-9])([0-9])/'), ' $0', $input);
    }

}

?>
