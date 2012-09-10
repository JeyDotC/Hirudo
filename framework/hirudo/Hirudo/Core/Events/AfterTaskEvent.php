<?php

namespace Hirudo\Core\Events;

use Symfony\Component\EventDispatcher\Event;
use Hirudo\Lang\Loader;

Loader::using("framework::libs::phpQuery::phpQuery");

/**
 * Description of AfterTaskEvent
 *
 * @author JeyDotC
 */
class AfterTaskEvent extends Event {

    /**
     *
     * @var \phpQueryObject
     */
    private $dom;
    
    private $result;

    function __construct($result) {
        $this->result = $result;
    }

    public function getTaskResult() {
        return isset($this->dom) ? $this->dom->htmlOuter() : $this->result;
    }

    /**
     * 
     * @return \phpQueryObject
     */
    public function getDocument($selector = "") {
        if(!isset($this->dom)){
            $this->dom = \phpQuery::newDocument($this->result);
        }
        
        if (empty($selector)) {
            return $this->dom;
        } else {
            return $this->dom[$selector];
        }
    }

    /**
     * 
     * @param type $param
     * @param type $context
     * @return \phpQueryObject
     */
    public function pq($param, $context = null) {
        return \phpQuery::pq($param, $context);
    }

}

?>
