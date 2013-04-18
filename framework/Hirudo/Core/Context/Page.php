<?php

namespace Hirudo\Core\Context;

use Hirudo\Core\Util\Message;

class Breadcrumb {

    private $title;
    private $url;

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
 *
 * @author JeyDotC
 */
interface Page {

    /**
     * 
     * @param string $title
     * 
     * @return Page $this
     */
    function setTitle($title); // Page

    /**
     * 
     * @param string $heading
     * 
     * @return Page $this
     */
    function setHeading($heading); // Page

    /**
     * 
     * @param \Hirudo\Core\Util\Message $message
     * 
     * @return Page $this
     */
    function addMessage(Message $message); // Page

    /**
     * 
     * @param string $title
     * @param string $url
     * 
     * @return Page $this
     */
    function addBreadcrumb($title, $url);

    /**
     * @return boolean 
     */
    function renderTitle(); // boolean

    /**
     * @return boolean 
     */
    function renderHeading(); // boolean

    /**
     * @return boolean 
     */
    function renderMessages(); // boolean

    /**
     * @return boolean 
     */
    function renderBreadcrumbs(); // boolean

    /**
     * @return string 
     */
    function getTitle(); // string

    /**
     * @return string 
     */
    function getHeading(); // string

    /**
     * @return array<Message> 
     */
    function getMessages(); // array<Message>

    /**
     * @return array<Breadcrumb>
     */
    function getBreadcrumbs(); // array<string, string>
    
    function __toString(); //Implementor should return empty string
}

?>
