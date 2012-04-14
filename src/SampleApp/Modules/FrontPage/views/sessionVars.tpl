{extends file="assets::smarty-templates::Master"|toPath}

{block name="title"}Session variables{/block}

{block name="header"}<h1>Some session variables</h1>{/block}

{block name="content"}
<p>
    These are some variables stored into the session:
</p>

<h2>A Simple String</h2>

<div>
    {var_dump($name)}
</div>

<h2>A ComplexObject</h2>

<div>
    {var_dump($object)}
</div>
    
{/block}