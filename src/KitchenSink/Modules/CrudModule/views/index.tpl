{extends file="assets::smarty-templates::Master"|toPath}


{block name="header"}Crud Module | Index{/block}

{block name="content"}
<p>
    Hello, this is a sample CRUD module.
</p>
<p>
    This is a list of Foo objects, they live in the session neighborhood:
</p>
<a href="{url call="KitchenSink::CrudModule::create"}">Create new Foo</a>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        {foreach $fooList as $foo}
            <tr>
                <td>
                    {$foo->getId()}
                </td>
                <td>
                    {$foo->getDescription()}
                </td>
                <td>
                    <a href="{url call="KitchenSink::CrudModule::view" id=$foo->getId()}">View</a> | 
                    <a href="{url call="KitchenSink::CrudModule::update" id=$foo->getId()}">Edit</a> | 
                    <a href="{url call="KitchenSink::CrudModule::remove"}">Remove</a>
                </td>
            </tr>
        {foreachelse}
            <tr>
                <td colspan="2">
                    There is no Foo to see.
                </td>
            </tr>
        {/foreach}
    </tbody>
</table>
{/block}