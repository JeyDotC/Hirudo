<?php

function smarty_block_page_messages($params, $content, Smarty_Internal_Template $template, &$repeat) {
    $pageContext = Hirudo\Core\Context\ModulesContext::instance()->getPage();

    if ($repeat) {
        $repeat = !$pageContext->renderMessages();
    } else {
        return $content;
    }
}

?>
