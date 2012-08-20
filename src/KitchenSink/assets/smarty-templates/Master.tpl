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
            {*
            This is a block section. These represent the overridable parts of this
            template. Any child template can optionally override these sections
            by just creating a block with the same name.
            
            This feature allow to do even more, the parent template can decide where
            the child overrides will appear, or the children templates can decide to
            append ther contents instead of overriding it.
            
            To know all the cool stuff about the block sections see: http://www.smarty.net/docs/en/language.function.block.tpl
            *}
            {block name="title"}Hirudo KitchenSink{/block}
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

        <div id="Notifications">
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
            {foreach $Module.messages as $message}
                <div class="message {$message->getType()}">
                    <strong>{$message->getTitle()}: </strong>
                    <span>
                        {$message->getMessage()}
                    </span>
                </div>
            {/foreach}
        </div>

        <div id="Navigation">
            <ul>
                <li><a href="{url call="KitchenSink::Welcome::index"}" title="Home page">Welcome</a></li> 
                <li><a href="{url call="KitchenSink::CrudModule::index"}" title="A CRUD sample starred by our friend Foo">Crud Module</a></li> 
                <li><a href="{url call="KitchenSink::Welcome::notifications"}" title="Some kinds of notifications">Notifications</a></li> 
                <li><a href="{url call="KitchenSink::Welcome::boomPage"}" title="I want to see an explosion!">Exceptions</a></li>
                <li><a href="{url call="Qwerty::Was::here"}" title="This link is broken">404 Page</a></li>
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
