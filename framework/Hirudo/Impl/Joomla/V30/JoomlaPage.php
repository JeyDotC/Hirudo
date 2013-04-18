<?php

namespace Hirudo\Impl\Joomla\V30;

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
class JoomlaPage implements Page {

    private $title;
    private $heading;
    private $breadcrumbs = array();
    private $messages = array();
    private $document;
    private $pathway;
    private $app;

    function __construct() {
        $this->app = \JFactory::getApplication();
        $this->document = \JFactory::getDocument();
        $this->pathway = $this->app->getPathway();
    }

    public function addBreadcrumb($title, $url) {
        $this->breadcrumbs[] = new Breadcrumb($title, $url);
        return $this;
    }

    public function addMessage(Message $message) {
        $this->messages[] = $message;
        $this->app->enqueueMessage($message->getMessage(), $message->getType());
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
        foreach ($this->breadcrumbs as $breadcrumb) {
            $this->pathway->addItem($breadcrumb->getTitle(), $breadcrumb->getUrl());
        }
        return true;
    }

    public function renderHeading() {
        return false;
    }

    public function renderMessages() {
        return true;
    }

    public function renderTitle() {
        $this->document->setTitle($this->title);
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

?>F