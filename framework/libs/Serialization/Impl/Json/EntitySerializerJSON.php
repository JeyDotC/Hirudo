<?php

/**
 * Description of EntitySerializerJSON
 *
 * @author JeyDotC
 */
class EntitySerializerJSON extends EntitySerializerBase {

    protected function doSerialize($array) {
        return json_encode($array);
    }

}

?>
