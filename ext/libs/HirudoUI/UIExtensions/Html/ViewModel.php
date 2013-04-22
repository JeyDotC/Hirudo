<?php

namespace UIExtensions\Html;

use Hirudo\Serialization\ArrayToEntityConverter;
use Hirudo\Serialization\EntityToArrayConverter;

/**
 * A base class for ViewModels. It has some utility static methods.
 *
 * @author JeyDotC
 */
class ViewModel {
    private static $normalizer;
    private static $deNormalizer;

    /** 
     * Creates a new instance of the class taking the data from the given entity.
     * The property names of the viewmodel must coincide with those of the entity
     * in order to be mapped from the entity to the viewmodel.
     * 
     * @param mixed $entity An entity object to take the values from.
     * @return ViewModel an instance of the viewmodel which values are coppied 
     * from the given entity.
     */
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
