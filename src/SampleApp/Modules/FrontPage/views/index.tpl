{*
    This line is for template inheritance from smarty, note the use of the 
    'toPath' modifier, this is a custom smarty plugin from Hirudo
    that converts the given string into an absolute path to a .tpl file (each '::' is
    conveerted into the 'DIRECTORY_SEPARATOR' character).
*}
{extends file="assets::smarty-templates::Master"|toPath}

{block name="header"}<h1>Hello {$name|upper}!</h1>{/block}

{block name="content"}
<div>
    <p>
        This is a sample Hirudo app, neat isn't it?
    </p>
    <form method="post" action="{$action}">
        <label for="name">
            User
        </label>
        {*
        Setting the property 'name' of the myComplexObject parameter using just 
        the input name.
        *}
        <input type="text" id="name" name="myComplexObject[name]" />
        <label for="pass">
            Pass
        </label>
        {*
        This is an alternative way to map object properties. Note the absense
        of the name="" html attribute in the input tag.
        *}
        <input type="password" id="pass" {bind to="myComplexObject.pass"} />
        <div>
            <label for="message">Message</label>
            {*
            The object can be as deep as necesary. Note that this is
            equivalent to: name="myComplexObject[simpleObject][message]"
            *}
            <textarea id="message" {bind to="myComplexObject.simpleObject.message"}></textarea>
        </div>
        <input type="submit" value="Enviar" />
    </form>
    <p>
        <a href="{$exceptionPage}">Go to a page that throws an exception</a>
    </p>
</div>
{/block}