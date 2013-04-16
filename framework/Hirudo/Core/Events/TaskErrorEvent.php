<?php

namespace Hirudo\Core\Events;

use Hirudo\Core\Exceptions\HirudoException;
use Symfony\Component\EventDispatcher\Event;

/**
 * Description of TaskErrorEvent
 *
 * @author JeyDotC
 */
class TaskErrorEvent extends Event {

    /**
     *
     * @var HirudoException
     */
    private $exception;
    
    /**
     *
     * @var string
     */
    private $result = "";

    function __construct(HirudoException $exception) {
        $this->exception = $exception;
    }
    

    /**
     * 
     * @return HirudoException
     */
    public function getException() {
        return $this->exception;
    }

    public function getResult() {
        return $this->result;
    }

    public function setResult($result) {
        $this->result = $result;
    }
}

?>
