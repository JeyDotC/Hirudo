<?php

namespace Hirudo\Core\Extensions\Plugins;

use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Events\Annotations\Listen;
use Hirudo\Core\Events\Annotations\VirtualListener;
use Hirudo\Core\Events\TaskErrorEvent;

/**
 * Description of TaskErrorDefaultPlugin
 *
 * @author JeyDotC
 */
class TaskErrorDefaultPlugin {

    /**
     * 
     * @param TaskErrorEvent $e
     * @Listen(to="taskError")
     * @VirtualListener(id="error_listener")
     */
    function onError(TaskErrorEvent $e) {
        $templating = ModulesContext::instance()->getTemplating();
        $templating->assign("ex", $e->getException());
        echo $templating->display(dirname(__FILE__) . DS, "index");
    }

}

?>
