<?php

namespace Hirudo\Libs\Serialization\Impl\Json;

use Hirudo\Libs\Serialization\EntityDeserializerBase;
/**
 * Description of EntityDeserializerJSON
 *
 * @author JeyDotC
 */
class EntityDeserializerJSON extends EntityDeserializerBase {

    protected function convertStringToArray($string) {
        return json_decode($string, true);
    }

}

?>
