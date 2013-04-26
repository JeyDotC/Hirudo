<?php

namespace Hirudo\Impl\StandAlone;

use Hirudo\Core\Annotations\Export;
use Hirudo\Core\Context\Breadcrumb;
use Hirudo\Core\Context\Page;
use Hirudo\Core\Util\Message;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author JeyDotC
 * @Export(id="page")
 */
class SAPage implements Page {

    private $title;
    private $heading;
    private $breadcrumbs = array();
    private $messages = array();

    public function addBreadcrumb($title, $url) {
        $this->breadcrumbs[] = new Breadcrumb($title, $url);
        return $this;
    }

    public function addMessage(Message $message) {
        $this->messages[] = $message;
        return $this;
    }

    public function getBreadcrumbs() {
        return $this->breadcrumbs;
    }

    public function getHeading() {
        return $this->heading;
    }

    public function getMessages() {
        return $this->messages;
    }

    public function getTitle() {
        return $this->title;
    }

    public function renderBreadcrumbs() {
        return false;
    }

    public function renderHeading() {
        return false;
    }

    public function renderMessages() {
        return false;
    }

    public function renderTitle() {
        return false;
    }

    public function setHeading($heading) {
        $this->heading = $heading;
        return $this;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function __toString() {
        return "";
    }

}

?>
