{extends file="assets::smarty-templates::Master"|toPath}

{block name="title"}404 - Not found{/block}

{block name="header"}404 - Page not found{/block}

{block name="content"}
<p>
    Mmmm, it seems like we are lost, maybe somebody forgot to write the link right or 
    the link is broken.
</p>
<p>
    Try going back with your browser or go to the  
    <a href="{url call="KitchenSink::Welcome::index"}" title="Go home! :)">
        home page.
    </a>
</p>
{/block}