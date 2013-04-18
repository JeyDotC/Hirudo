<?php

namespace Hirudo\Impl\Drupal;

use Hirudo\Core\Annotations\Export;
use Hirudo\Core\Context\Breadcrumb;
use Hirudo\Core\Context\Page;
use Hirudo\Core\Util\Message;

/**
 *
 * @author JeyDotC
 * @Export(id="page")
 */
class DrupalPage implements Page {

    private $title;
    private $heading;
    private $breadcrumbs = array();
    private $messages = array();

    function __construct() {
        $this->breadcrumbs[0] = new Breadcrumb('Home', '<front>');
    }

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
        $breadcrumbs = array();
        foreach ($this->breadcrumbs as /* @var $breadcrumb Breadcrumb */ $breadcrumb) {
            if ($breadcrumb->getUrl()) {
                $breadcrumbs[] = \l($breadcrumb->getTitle(), $breadcrumb->getUrl());
            } else {
                $breadcrumbs[] = $breadcrumb->getTitle();
            }
        }
        \drupal_set_breadcrumb($breadcrumbs);
        return true;
    }

    public function renderHeading() {
        return false;
    }

    public function renderMessages() {
        foreach ($this->messages as /* @var $message Message */ $message) {
            \drupal_set_message($message->getMessage(), $message->getType());
        }
        return true;
    }

    public function renderTitle() {
        \drupal_set_title($this->title);
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
