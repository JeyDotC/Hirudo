{extends file="KitchenSink::smarty-templates/Master"|toAssetPath}


{block name="header"}Crud Module | View{/block}

{block name="content"}
<div>
    <h2>Foo number {$foo->getId()}</h2>
    <p>
        {$foo->getDescription()}
    </p>
    <div>
        <h3>Bar information</h3>
        <p>
            Bar number: {$foo->getBar()->getId()}
        </p>
        <p>
            Bar name: {$foo->getBar()->getName()}
        </p>
    </div>
</div>
{/block}