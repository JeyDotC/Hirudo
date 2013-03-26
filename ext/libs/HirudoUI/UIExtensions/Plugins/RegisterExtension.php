<?php

namespace UIExtensions\Plugins;

use Hirudo\Core\Context\ModulesContext;
use Hirudo\Core\Events\Annotations\Listen;
use Hirudo\Core\Events\BeforeTaskEvent;
use Hirudo\Lang\Loader;
use UIExtensions\Html\HtmlHelper;

/**
 * Description of RegisterExtension
 *
 * @author JeyDotC
 */
class RegisterExtension {

    private static $templating;

    /**
     * @param BeforeTaskEvent $e 
     * 
     * @Listen(to="beforeTask")
     */
    function registerHtmlHelper(BeforeTaskEvent $e) {
        if (!isset(self::$templating)) {
            self::$templating = ModulesContext::instance()->getTemplating();
            $app = $e->getCall()->getApp();
            self::$templating->assign("html", new HtmlHelper(self::$templating, Loader::toSinglePath("$app::assets::smarty-templates", "")));
        }
    }

}

?>
