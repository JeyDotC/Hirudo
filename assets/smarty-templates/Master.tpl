<html>
    <head>
        <title>{block name="title"}Home page{/block}</title>
    </head>
    <body>
        <div>
            {block name="header"}Hirudo Sample App{/block}
        </div>

        <div>
            {block name="content"}
            This content gets overriden by the child template, if it does so.
            {/block}
        </div>
    </body>
</html>
