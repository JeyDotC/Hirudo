<div>
    <h1>Hello {$name|upper}!</h1>
    <p>
        This is a sample Hirudo app, cute isn't it?
    </p>
    <form method="post" action="{$action}">
        <label>
            User
        </label>
        <input type="text" name="myComplexObject[name]" />
        <label>
            Pass
        </label>
        <input type="text" name="myComplexObject[pass]" />
        <input type="submit" value="Enviar" />
    </form>
</div>