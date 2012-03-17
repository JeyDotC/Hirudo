<?php

namespace Hirudo\Libs\Impl\StandAlone;

/**
 * 
 */
class JSON {

    public static function Encode($obj) {
        return json_encode($obj);
    }

    public static function Decode($json, $toAssoc = false) {
        $result = json_decode($json, $toAssoc);
        switch (json_last_error()) {
            case JSON_ERROR_DEPTH:
                $error = ' - Maximum stack depth exceeded';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = ' - Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                $error = ' - Syntax error, malformed JSON';
                break;
            case JSON_ERROR_NONE:
            default:
                $error = '';
        }
        if (!empty($error))
            throw new Exception('JSON Error: ' . $error);

        return $result;
    }

}

?>
