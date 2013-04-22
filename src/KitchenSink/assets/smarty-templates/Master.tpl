{*
This is a master page. It gives the general structure to the application's views,
all they have to do is to inherit this template and override it's block sections.

To learn more about Smarty's template inheritance see http://www.smarty.net/inheritance
*}
<html>
    <head>
        {*
        This function renders a <link> tag that points to the given stylesheet. The stylesheet
        should be at the assets directory under the css/ folder.
        
        Even though you can have any folder structure under the assets folder, you will
        need just to set the file parameter to: "AppName::path/to/my/cssFile.css".
        
        Note: this function doesn't come with Smarty, is an extension provided by Hirudo.
        *}
        {css file="KitchenSink::css/kitchensink.style.css"}
        {*
        This function renders a <script> tag that points to the given javascript file. 
        The script should be at the assets directory under the js/ folder.
        
        Even though you can have any folder structure under the assets folder, you will
        need just to set the file parameter to: "AppName::path/to/my/jsFile.js".
        
        Note: this function doesn't come with Smarty, is an extension provided by Hirudo.
        *}
        {js file="KitchenSink::js/script.js"}
        
        <title>
            {block "title"}
                {*
                With this function we print the title. Note that we are doing this
                inside a header > title tag, this is a falback in case the CMS doesn't
                render the title for us.
                *}
                {page_title t="Hirudo KitchenSink"}
            {/block}
        </title>
    </head>
    <body>
        <div id="Header">
            {*
            Ok, this is a normal link- oh wait, there is a smarty function in the
            'href' value. That function generates Hirudo URLs, it receives a string
            this this format: "AppName::ModuleName::methodName".
            
            Remember that the resulting URL depends on the current Hirudo implementations, so
            it is a bad idea to create the URLs by your own.
            
            Note: this function doesn't come with Smarty, is an extension provided by Hirudo.
            *}
            <a href="{url call="KitchenSink::Welcome::index"}">Go to index</a>
            <h1>{block name="header"}Here you can put your default title{/block}</h1>
        </div>

        {*
        The next lines add the breadcrumbs to the page. The page_add_breadcrumb function
        receives a title and a call which is a string with the form "AppName::ModuleName::task"
        which in time gets converted into a URL.
        
        The breadcrumbs can be added at the module by calling $this->page->addBreadcrumb($title, $url);
        *}
        {page_add_breadcrumb title=$Module.appName call="{$Module.appName}::Welcome::index"}
        {if $Module.task != "index"}
            {page_add_breadcrumb title=$Module.name call="{$Module.appName}::{$Module.name}::index"}
            {page_add_breadcrumb title=$Module.task}
        {else}
            {page_add_breadcrumb title=$Module.name}
        {/if}

        {*
        Actually render the breadcrumb. This block function tries to delegate the
        breadcrumb rendering to the CMS. If the CMS doesn't render the breadcrumbs
        for you, the content of this block gets invoked.
        *}
        {page_breadcrumbs}
        {*
        This is a fallback breadcrumb render. This is called only if the containing
        CMS doesn't render the breadcrumbs for you.
        
        If, for example, you are using hirudo for joomla, you can omit this code 
        and just use {page_breadcrumbs}{/page_breadcrumbs}. 
        
        Doing this fallback content is encouraged if you are willing to support various
        CMS for your application.
        *}
        <div id="Breadcrumbs">
             {*
            This is a normal smarty foreach. But where did that '$Module'
            variable came from? 
            
            The $Module variable is added by the base Module class before rendering
            the template, and is an array with some information such as the name 
            of the module that invoked this view and, as in this case, the list 
            of messages added by the invoking module.
            
            To know more about this variable see: https://github.com/JeyDotC/Hirudo-docs/blob/master/Hirudo/Core/Module.md#display
            To know more about arrays in smarty templates see: http://www.smarty.net/docs/en/language.variables.tpl#language.variables.assoc.arrays
            *}
            {foreach $Module.page->getBreadcrumbs() as $breadcrumb}
                {if $breadcrumb->getUrl()}
                    <a href="{$breadcrumb->getUrl()}">{$breadcrumb->getTitle()}</a> / 
                {else}
                    {$breadcrumb->getTitle()} / 
                {/if}
            {/foreach}
        </div>
        {/page_breadcrumbs}

        {page_messages}
        <div id="Notifications">
            {foreach $Module.page->getMessages() as $message}
                <div class="kitchensink-message kitchensink-type-{$message->getType()}">
                    <strong>{$message->getTitle()}: </strong>
                    <span>
                        {$message->getMessage()}
                    </span>
                </div>
            {/foreach}
        </div>
        {/page_messages}

        <div id="Navigation">
            <ul>
                <li><a href="{url call="KitchenSink::Welcome::index"}" title="Home page">Welcome</a></li> 
                <li><a href="{url call="KitchenSink::CrudModule::index"}" title="A CRUD sample starred by our friend Foo">Crud Module</a></li> 
                <li><a href="{url call="KitchenSink::Welcome::notifications"}" title="Some kinds of notifications">Notifications</a></li> 
                <li><a href="{url call="KitchenSink::Welcome::boomPage"}" title="I want to see an explosion!">Exceptions</a></li>
                <li><a href="{url call="Qwerty::Was::here"}" title="This link is broken">404 Page</a></li>
                <li><a href="{url call="KitchenSink::EventListening::broadCastEvent"}" title="See event listening in action">Event listening</a></li>
            </ul>
        </div>

        <div id="Content">
            {block name="content"}
                This content gets overriden by the child template, if it does so.
                You can create as many block sections as you like. See 
                http://www.smarty.net/docs/en/language.function.block.tpl
                for more details.
            {/block}
        </div>
    </body>
</html>
