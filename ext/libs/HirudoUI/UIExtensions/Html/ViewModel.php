<?php

namespace UIExtensions\Html;

use Hirudo\Serialization\ArrayToEntityConverter;
use Hirudo\Serialization\EntityToArrayConverter;

/**
 * Description of ViewModel
 *
 * @author JeyDotC
 */
class ViewModel {
    private static $normalizer;
    private static $deNormalizer;

    public static function fromEntity($entity) {
        $array = self::getNormalizer()->convert($entity);
        $class = get_called_class();
        $self = new $class();
        
        return self::getDeNormalizer()->convert($array, $self);
    }
    
    /**
     * 
     * @return EntityToArrayConverter
     */
    protected static function getNormalizer() {
        if(!isset(self::$normalizer)){
            self::$normalizer = new EntityToArrayConverter();
        }
        
        return self::$normalizer;
    }
    
    /**
     * 
     * @return ArrayToEntityConverter
     */
    protected static function getDeNormalizer() {
        if(!isset(self::$deNormalizer)){
            self::$deNormalizer = new ArrayToEntityConverter();
        }
        
        return self::$deNormalizer;
    }
}

?>
