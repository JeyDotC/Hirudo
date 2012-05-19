<html>
    <head>
        {css file="css/style.css"}
        <title>{block name="title"}Home page{/block}</title>
    </head>
    <body>
        <div>
            <div>
                <a href="{url call="SampleApp::FrontPage"}">Go to index</a>
            </div>
            {block name="header"}Hirudo Sample App{/block}
        </div>

        <div>
            {block name="content"}
            This content gets overriden by the child template, if it does so.
            {/block}
        </div>
    </body>
</html>
