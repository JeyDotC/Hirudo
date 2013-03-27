{extends file="KitchenSink::smarty-templates/Master"|toAssetPath}


{block name="header"}Crud Module | Index{/block}

{block name="content"}
    <p>
        Hello, this is a sample CRUD module.
    </p>
    <p>
        This is a list of Foo objects, they live in the session neighborhood.
        Note that the table is rendered twice, this is to show the different ways
        you can render a table, using the traditional "hard-coded" way or by having
        a GridModel:
    </p>
    <a href="{url call="KitchenSink::CrudModule::create"}">Create new Foo</a>
    {nocache}
        {*Rendering the table the usual way: *}
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
                            {*
                            Note that when we call the {url} function, we also add an 'id' param;
                            in fact, any parameter different from 'call' will be added to the url as
                            a GET param.
                            *}
                            <a href="{url call="KitchenSink::CrudModule::view" id=$foo->getId()}">View</a> | 
                            <a href="{url call="KitchenSink::CrudModule::edit" id=$foo->getId()}">Edit</a> | 
                            <a href="{url call="KitchenSink::CrudModule::remove" id=$foo->getId()}">Remove</a>
                        </td>
                    </tr>
                {foreachelse}
                    <tr>
                        <td colspan="3">
                            There is no Foo to see.
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
        
        {*Rendering the same table using a GridModel: *}
        {* Note the function new_, that is a helper function that creates a new instance of
        the given class. That function can also receive any extra parameters that will be passed
        to the constructor.*}
        {$gridModel = new_("KitchenSink\Modules\CrudModule\ViewModels\FooGridModel")}
        
        {*This is the smarty function that does the trick, it receives our collection
        and an instance of GridModel. Note that if you delete the '->withActions()' part
        the column with the links will disappear, that is a proof of the flexibility
        of grid models.*}
        {grid for=$fooList 
              withModel=$gridModel->withActions()}
    {/nocache}
{/block}