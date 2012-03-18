<?php

namespace Hirudo\Core\Exceptions;

/**
 * Description of HirudoException
 *
 * @author JeyDotC
 */
class HirudoException extends Exception {

    /**
     *
     * @var ModuleCall
     */
    private $call;

    public function __construct(ModuleCall $call, $message = "",
            $previous = null) {
        
        $exceptionMessage = !empty($message) ?
                $message : "An exception ocurred at {$call->getApp()}::{$call->getModule()}::{$call->getTask()}(). View the inner exception for more information.";
        if (!empty($previous)) {
            parent::__construct(
                    $exceptionMessage, 0, $previous);
        } else {
            parent::__construct($exceptionMessage);
        }

        $this->call = $call;
    }

    public function getApp() {
        return $this->call->getApp();
    }

    public function getModule() {
        return $this->call->getModule();
    }

    public function getTask() {
        return $this->call->getTask();
    }

}

?>
