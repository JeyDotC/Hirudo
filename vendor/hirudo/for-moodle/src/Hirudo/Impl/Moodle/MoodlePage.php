<?php

namespace Hirudo\Impl\Moodle;

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
class MoodlePage implements Page {

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
        global $PAGE;
        $PAGE->navbar->ignore_active();
        foreach ($this->breadcrumbs as $breadcrumb) {
            $PAGE->navbar->add($breadcrumb->getTitle(), $breadcrumb->getUrl());
        }
        return true;
    }

    public function renderHeading() {
        global $PAGE;
        $PAGE->set_heading(\format_string("The heading"));
        return true;
    }

    public function renderMessages() {
        return false;
    }

    public function renderTitle() {
        global $PAGE;
        $PAGE->set_title(\format_string($this->title));
        return true;
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
