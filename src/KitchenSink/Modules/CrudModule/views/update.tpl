{extends file="assets::smarty-templates::Master"|toPath}


{block name="header"}Crud Module | Update{/block}

{block name="content"}
<form action="{$action}" method="post">
    <input type="hidden" {bind to="foo.id"} id="foo_id" value="{$foo->getId()}" />
    <label for="foo_description">Description:</label>
    <div>
        <textarea name="foo[description]" id="foo_description">{$foo->getDescription()}</textarea>
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
{/block}