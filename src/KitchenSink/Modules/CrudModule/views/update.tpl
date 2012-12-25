{extends file="KitchenSink::smarty-templates/Master"|toAssetPath}


{block name="header"}Crud Module | Update{/block}

{block name="content"}
<a href="{url call="KitchenSink::CrudModule::index"}">Back to the Foo list</a>
{nocache}
<form action="{$action}" method="post">
    <input type="hidden" {bind to="foo.id"} id="foo_id" value="{$foo->getId()}" />
    <label for="foo_description">Description:</label>
    <div>
        {*
        Here is where we can see another Hirudo function, the 'bind'
        function, is like typing name="foo[bar][name]", but with a litle
        clearer syntax.
        
        You can use any of both options, Hirudo wont complain ;)
        *}
        <textarea {bind to="foo.description"} id="foo_description">{$foo->getDescription()}</textarea>
    </div>
    <fieldset>
        <input type="hidden" {bind to="foo.bar.id"} id="foo_bar_id" value="{$foo->getBar()->getId()}" />
        <legend>Bar information</legend>
        <p>
            <label for="foo_bar_name">Bar name:</label> 
            <input type="text" {bind to="foo.bar.name"} id="foo_bar_name" value="{$foo->getBar()->getName()}" />
        </p>
    </fieldset>
    <button type="submit" >Save</button> | 
    <a href="{url call="KitchenSink::CrudModule::index"}">Cancel</a>
</form>
{/nocache}
{/block}