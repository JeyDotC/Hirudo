<?php

namespace Hirudo\Core\Extensions\TaskRequirements\Annotations;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Tells to the task parameter resolver plugin how to resolve the method parameters.
 * 
 * This annotation is optional, omiting it will cause the plugin to use inteligent 
 * gess to determine the parameters' sources.
 * 
 * @author JeyDotC
 * @Annotation
 * @Target({"METHOD"})
 */
class Resolve {

    /**
     * An array where keys are the task's paremeters names and the values are the
     * sources from which the plugin will look for such values.
     * 
     * The default available sources are "get", "post", "cookie", "env" and "server"
     * But other extensions may provide their own values so they can resolve parameters
     * from any kind of sources.
     * 
     * @var array
     */
    public $value;

    public function __construct(array $values) {
        if (!isset($values['value'])) {
            $values['value'] = null;
        }
        if (is_string($values['value'])) {
            $values['value'] = array($values['value']);
        }
        if (!is_array($values['value'])) {
            throw new \InvalidArgumentException(
                    sprintf('@HttpMethod expects either a string value, or an array of strings, "%s" given.', is_object($values['value']) ? get_class($values['value']) : gettype($values['value'])
                    )
            );
        }

        $this->value = $values['value'];
    }

}

?>
