<?php

namespace Hirudo\Core\Events\Annotations;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * <p>Signals a Task event listener to only listen the event
 * when the current call matches the given characteristics.</p>
 * 
 * Example:
 * 
 * <code>
 * ForCall(app="MyApp", module="Amodule", task="aTask")
 * </code>
 * 
 * <p>Indicates that the event listener will only listen the event when the call
 * is for the 'MyApp' application on the 'Amodule' module in the 'aTask' task.</p>
 * 
 * <p>Omitting any of those characteristics indicates that the event will be 
 * listened for any value of it. For example, omitting the app and module values
 * will cause the event to be listened for any application and module but only on
 * the 'aTask' task.</p>
 * 
 * @author JeyDotC
 * 
 * @Annotation
 * @Target("CLASS")
 */
class ForCall {

    /**
     *
     * @var string
     */
    public $app = "";

    /**
     *
     * @var string 
     */
    public $module = "";

    /**
     *
     * @var string 
     */
    public $task = "";

}

?>
