{extends file="KitchenSink::smarty-templates/Master"|toAssetPath}


{block name="header"}Crud Module | Update{/block}

{block name="content"}
    <a href="{url call="KitchenSink::CrudModule::index"}">Back to the Foo list</a>
    {nocache}
        <form action="{$action}" method="post">
            {editor for="foo.id"}
            {editor for="foo.description"}
            <fieldset>
                <legend>Bar information</legend>
                <p>
                    {editor for="foo.bar.name"} 
                </p>
            </fieldset>
            <button type="submit" >Save</button> | 
            <a href="{url call="KitchenSink::CrudModule::index"}">Cancel</a>
        </form>
    {/nocache}
{/block}