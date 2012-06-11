{extends file="assets::smarty-templates::Master"|toPath}


{block name="header"}Crud Module | Create{/block}

{block name="content"}
<form action="{$action}" method="post">
    <label for="foo_description">Description:</label>
    <div>
        <textarea name="foo[description]" id="foo_description"></textarea>
    </div>
    <fieldset>
        <legend>Bar information</legend>
        <p>
            <label for="foo_bar_name">Bar name:</label> 
            <input type="text" {bind to="foo.bar.name"} id="foo_bar_name" />
        </p>
    </fieldset>
    <button type="submit" >Save</button> | 
    <a href="{url call="KitchenSink::CrudModule::index"}">Cancel</a>
</form>
{/block}