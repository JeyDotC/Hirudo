<?php

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
