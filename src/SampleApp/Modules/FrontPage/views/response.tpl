{extends file="assets::smarty-templates::Master"|toPath}

{block name="title"}Response Page{/block}

{block name="header"}<h1>This is the data you have provided:</h1>{/block}

{block name="content"}
<div>
    {*
    This is another Hirudo custom smarty plugin, this can be used to generate
    Hirudo URLs from a string with this notation: "AppName::ModuleName::viewName"
    *}
    <a href="{url call="SampleApp::FrontPage::index"}">Get Back</a>
    <p>
        Name: {$myObject->getName()}
    </p>
    <p>
        Pass: {$myObject->getPass()}
    </p>
    <p>
        Message: '{$myObject->getSimpleObject()->getMessage()}'
    </p>
    <a href="{$sessionVarsUrl}">See  what got stored into session.</a>
</div>
{/block}