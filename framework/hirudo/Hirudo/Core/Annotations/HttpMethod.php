<?php
namespace Hirudo\Core\Annotations;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Signals a task to accept a set of request types only. Can be one or
 * more of: GET, POST, PUT or DELETE
 * 
 * @Annotation
 * @Target("METHOD")
 */
class HttpMethod {
    
    public $value;

    public function __construct(array $values)
    {
        if (!isset($values['value'])){
            $values['value'] = null;
        }
        if (is_string($values['value'])){
            $values['value'] = array($values['value']);
        }
        if (!is_array($values['value'])){
            throw new \InvalidArgumentException(
                sprintf('@HttpMethod expects either a string value, or an array of strings, "%s" given.',
                    is_object($values['value']) ? get_class($values['value']) : gettype($values['value'])
                )
            );
        }

        $this->value = $values['value'];
    }
}

?>
