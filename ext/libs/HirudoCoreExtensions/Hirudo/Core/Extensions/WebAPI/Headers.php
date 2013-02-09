<?php

namespace Hirudo\Core\Extensions\WebApi;

/**
 * Description of Headers
 *
 * @author JeyDotC
 */
class Headers {

    private static $headers;

    public static function get($key) {
        if(!isset(self::$headers)){
            self::$headers = self::parseRequestHeaders();
        }
        
        return self::$headers[$key];
    }
    
    private static function parseRequestHeaders() {
        $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        $headers["Content-Type"] = isset($_SERVER["CONTENT_TYPE"]) ? $_SERVER["CONTENT_TYPE"] : "text/plain";
        return $headers;
    }

}

?>
