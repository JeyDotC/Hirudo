{extends file="KitchenSink::smarty-templates/Master"|toAssetPath}


{block name="header"}Crud Module | Create{/block}

{block name="content"}
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
        <p>
            <label for="foo_bar_name">Bar name:</label> 
            {*
            Mmmmm, but you are not using the array convention here, in fact, you
            are not giving the input a name at all!
            
            Well, here is where we can see another Hirudo function, the 'bind'
            function, is like typing name="foo[bar][name]", but with a litle
            clearer syntax.
            
            You can use any of both options, Hirudo wont complain ;)
            *}
            <input type="text" {bind to="foo.bar.name"} id="foo_bar_name" />
        </p>
    </fieldset>
    <button type="submit" >Save</button> | 
    <a href="{url call="KitchenSink::CrudModule::index"}">Cancel</a>
</form>
{/block}