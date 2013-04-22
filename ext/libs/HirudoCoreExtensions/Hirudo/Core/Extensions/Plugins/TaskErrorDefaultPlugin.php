<?php

namespace Hirudo\Core\Extensions\Plugins;

use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Events\Annotations\Listen;
use Hirudo\Core\Events\Annotations\VirtualListener;
use Hirudo\Core\Events\TaskErrorEvent;

/**
 * This plugin shows a default error page with debug information
 * when an unhandled exception occurs during a task execution.
 *
 * @todo Change the views/index.tpl file to a php normal file to avoid templating issues.
 * @author JeyDotC
 */
class TaskErrorDefaultPlugin {

    /**
     * Listens to the taskError event in order to present a default error page.
     * 
     * @param TaskErrorEvent $e
     * @Listen(to="taskError")
     * @VirtualListener(id="error_listener")
     */
    function onError(TaskErrorEvent $e) {
        $templating = ModulesContext::instance()->getTemplating();
        $templating->assign("ex", $e->getException());
        echo $templating->display(dirname(__FILE__) . DS . "views" . DS . "index");
    }

}

?>
