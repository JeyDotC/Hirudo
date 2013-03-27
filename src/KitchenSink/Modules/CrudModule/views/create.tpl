{extends file="KitchenSink::smarty-templates/Master"|toAssetPath}


{block name="header"}Crud Module | Create{/block}

{block name="content"}
    <a href="{url call="KitchenSink::CrudModule::index"}">Back to the Foo list</a>
    <form action="{$action}" method="post">
        <label for="foo_description">Description:</label>
        <div>
            {*
            As described in the save function of CrudModule, the type hinted
            parameters are resolved from an array taken from POST. 
            
            To send an array to the POST, is necesary to just name your fields with 
            an array notation, where foo[description] will be translated to something like this:
            
            $_POST["foo"] = array(
            "description" => "Whatever value from form"
            )
            
            The array can have any depth allowing to do thigs like: foo[bar][name]
            
            And no, this is not a Hirudo feature, is something that comes with PHP.
            *}
            <textarea name="foo[description]" id="foo_description"></textarea>
        </div>
        <fieldset>
            <legend>Bar information</legend>
            {*
            Here is the most powerful way to render fields in Hirudo. It consists
            in calling a value from template (the foo part of the string) which
            were assigned at the create method of the CrudModule and then accessing
            to the fields of that object (the rest of the string). 
            Note that the targetted field can be as nested as necesary.
            
            The generated field will have the current field's value and the name
            will be the propper format: foo[bar][name].
            *}
            {editor for="foo.bar.name"}
        </fieldset>
        <button type="submit" >Save</button> | 
        <a href="{url call="KitchenSink::CrudModule::index"}">Cancel</a>
    </form>
{/block}