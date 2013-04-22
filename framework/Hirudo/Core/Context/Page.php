<?php

namespace Hirudo\Core\Context;

use Hirudo\Core\Util\Message;

/**
 * A simple representation of a breadcrumb.
 */
class Breadcrumb {

    private $title;
    private $url;

    /**
     * Creates a breadcrumb with the given title for the given url.
     * 
     * @param string $title
     * @param string $url
     */
    function __construct($title, $url) {
        $this->title = $title;
        $this->url = $url;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getUrl() {
        return $this->url;
    }

}

/**
 * Represents the current page context, allow modification of common parts like
 * the title or the breadcrumb.
 * 
 * @author JeyDotC
 */
interface Page {

    /**
     * Sets page title, the one at head > title.
     * 
     * @param string $title The new page title.
     * 
     * @return Page $this
     */
    function setTitle($title);

    /**
     * Changes the page heading.
     * 
     * @param string $heading The new heading
     * 
     * @return Page $this
     */
    function setHeading($heading);

    /**
     * Adds a notification for the page.
     * 
     * @param \Hirudo\Core\Util\Message $message The notification to be added to
     * the page.
     * 
     * @return Page $this
     */
    function addMessage(Message $message);

    /**
     * Adds a breadcrumb entry.
     * 
     * @param string $title The title for the breadcrumb.
     * @param string $url The url for the breadcrumb.
     * 
     * @return Page $this
     */
    function addBreadcrumb($title, $url);

    /**
     * Render the title if possible.
     * 
     * @return boolean true if the current CMS allows the title to be overriden, 
     * false otherwise.
     */
    function renderTitle();

    /**
     * Render the heading if possible.
     * 
     * @return boolean true if the current CMS allows the heading to be overriden, 
     * false otherwise.
     */
    function renderHeading();

    /**
     * Render the messages if possible.
     * 
     * @return boolean true if the current CMS can render the messages for you, 
     * false otherwise.
     */
    function renderMessages();

    /**
     * Render the breadcrumbs if possible.
     * 
     * @return boolean true if the current CMS can render the breadcrumbs for you, 
     * false otherwise.
     */
    function renderBreadcrumbs();

    /**
     * Gets the title given at setTitle.
     * @return string 
     */
    function getTitle();

    /**
     * Gets the hedaing given at setHeading.
     * @return string 
     */
    function getHeading();

    /**
     * Gets the list of messages added up to now.
     * 
     * @return array<Message> 
     */
    function getMessages();

    /**
     *  Gets the list of breadcrumbs added up to now.
     * 
     * @return array<Breadcrumb>
     */
    function getBreadcrumbs();
    
    /**
     * @return string Always return an empty string!
     */
    function __toString();
}

?>
