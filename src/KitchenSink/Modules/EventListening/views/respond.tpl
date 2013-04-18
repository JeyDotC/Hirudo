{extends file="KitchenSink::smarty-templates/Master"|toAssetPath}

{block "title"}
    {page_title t="Events"}
{/block}

{block name="header"}Responding to a custom event{/block}

{block name="content"}
<p>
    <em>{$coolMessage}</em>  brough to you by an event listener that listens to a custom event!
</p>
{/block}