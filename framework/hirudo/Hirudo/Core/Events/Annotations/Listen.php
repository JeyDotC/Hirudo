<?php

namespace Hirudo\Core\Events\Annotations;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Marks a method as an event listener.
 * 
 * Usage:
 * 
 * <code>
 * Listen(to="eventName")
 * </code>
 * 
 * The listener can optionally be restricted to a call or set of calls by using the
 * <code>constraints</code> parameter.
 * 
 * Example:
 * 
 * <code>
 * Listen(to="eventName", constraints={"App::Module::Task", "AnotherApp::AnotherModule::otherTask", ...})
 * </code>
 * 
 * Is possible to use regular expressions, just avoid using the slash (/) delimiters.
 * 
 * @author JeyDotC
 * 
 * @Annotation
 * @Target("METHOD")
 */
class Listen {
    /**
     * 
     * @var string
     */
    public $to;
    
    /**
     *
     * @var array<string> 
     */
    public $constraints = array();


    /**
     *
     * @var int 
     */
    public $priority = 0;
}

?>
