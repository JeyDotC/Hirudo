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

namespace Hirudo\Core\Util;

/**
 * A simple notification representation wich consists on a title, a message
 * and a type, being the latter normally used as a CSS class.
 */
class Message {
    //Some basic message types.

    const INFO = "info";
    const WARNING = "warning";
    const DOWLOAD = "download";
    const ERROR = "error";
    const SUCCESS = "success";
    const TIP = "tip";
    const SECURE_AREA = "secure";
    const MESSAGE = "message";
    const PURCHASE = "purchase";
    const PRINT_BOX = "print";

    private $title;
    private $message;
    private $type;

    function __construct($message, $title = "", $type = self::INFO) {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

}
