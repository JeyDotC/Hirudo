<?php

namespace SampleApp\Models\Entities;

/**
 * Description of SimpleObject
 *
 * @author JeyDotC
 */
class SimpleObject {

    /**
     *
     * @var string 
     */
    private $message;

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

}
?>
