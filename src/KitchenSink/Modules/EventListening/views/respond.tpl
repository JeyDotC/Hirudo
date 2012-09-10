{extends file="KitchenSink::smarty-templates/Master"|toAssetPath}

{block name="title"}Custom event response{/block}

{block name="header"}Responding to a custom event{/block}

{block name="content"}
<p>
    {$coolMessage}
</p>
{/block}