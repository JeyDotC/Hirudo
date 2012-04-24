<?php

/**
 * «Copyright 2012 Jeysson José Guevara Mendivil(JeyDotC)» 
 * 
 * This file is part of Hirudo.
 * 
 * Hirudo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 *  Hirudo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 * 
 *  You should have received a copy of the GNU General Public License
 *  along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Core\Exceptions;

use Hirudo\Core\Context\ModuleCall;

/**
 * Description of HirudoException
 *
 * @author JeyDotC
 */
class HirudoException extends \Exception {

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
