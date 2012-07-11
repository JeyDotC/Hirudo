{*
    As you can see for this smarty function, this view inherits from a master view.
    That view is located at [assets/smarty-templates/Master.tpl](https://github.com/JeyDotC/Hirudo/blob/master/assets/smarty-templates/Master.tpl).
    
    Note that the string given to the function has the format "path::to::myTemplate"
    and is modified by the 'toPath' modifier.
    
    That is because the smarty 'extend' function usually works only with the absolute
    path to the template file. 
    
    To avoid writing problematic abosolute paths in your views, you can use the 
    toPath modifier which convets the given string into an absolute path by 
    converting the :: into directory separators and prepending the absolute path 
    to the Hirudo folder.
    
    Also, the toPath modifier has a parameter, which is the file extension 
    (".tpl" by default).
    
    To know more about smarty modifiers see: http://www.smarty.net/docs/en/language.modifiers.tpl
    
    Note: The toPath modifier is a custom modifier from Hirudo.
*}
{extends file="KitchenSink::smarty-templates/Master"|toAssetPath}

{*Here we override the title of the parent template, which is at the head > title tag.*}
{block name="title"}Welcome to Hirudo{/block}

{*This is the main title of the page, the one at the #Header > h1 tag*}
{block name="header"}Welcome to Hirudo{/block}

{*An this is our main content.*}
{block name="content"}
<p>
    This is a Kitchen Sink Hirudo app. Is intended to be an example of how to use
    Hirudo for web development.
</p>
{/block}