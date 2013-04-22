{function name="PrintException" ex=""}
<h3>{get_class($ex)}</h3>
<div class = "debug-message">{$ex->getMessage()}</div>
<div>
    At <span class="debug-file">{$ex->getFile()}</span>
    (<span class="debug-line">{$ex->getLine()}</span>)
</div>
<div class="dl">
    {$trace = $ex->getTrace()}
    {if $trace}
        <div class="dt">Stack trace</div >
        <div class="dd">{call name="PrintStackTrace" stack=$ex->getTrace()}</div>
    {/if}
    {$prev = $ex->getPrevious()}
    {if $prev}
        <div class="dt">Inner exception</div>
        <div class="dd">
            {call name="PrintException" ex=$prev}
        </div>
    {/if}
</div>
{/function}

{function name="PrintStackTrace" stack=array()}
<ol class="stack-trace">
    {foreach $stack as $item}
        <li>
            <div class="method-call">
                {if array_key_exists("class", $item)}
                    <strong class="debug-class">{$item["class"]}</strong>
                    <span class="debug-type">{$item["type"]}</span>
                {/if}
                <strong class="debug-function">{$item["function"]}</strong>(
                {foreach $item["args"] as $arg}
                    {if is_object($arg)}
                        <em>object:</em> {get_class($arg)}
                    {else}
                        <em>{gettype($arg)}:</em>
                    {/if}
                    {if is_scalar($arg)}
                        <span class="debug-literal">"{$arg}"</span>
                    {/if}
                    {if !$arg@last}
                        ,
                    {/if}
                {/foreach})
            </div>
            <div class="location">
                {if array_key_exists("file", $item)}
                    At <span class='debug-file'>{$item["file"]}</span>
                {/if}
                {if array_key_exists("line", $item)}
                    (<span class='debug-line'>{$item["line"]}</span>): 
                {/if}
            </div>
        </li>
    {/foreach}
</ol>
{/function}

<html>
    <head>
        <title>Boom!</title>
        <style type="text/css">
            {literal}
                .dl, .dt, .dd{
                    text-align: left;
                    display: block !important;
                    float: none !important;
                }
                .dd .dl{
                    margin-left: 80px;
                }
                .debug-file{
                    color:#990000;
                }
                .debug-line{
                    color:green; 
                }

                .debug-message{
                    color: #3366FF;
                }
                .debug-literal{
                    color: #E03F0D;
                }
                .stack-trace div.method-call {
                    margin-left: 10px;
                }
                .stack-trace li {
                    margin-bottom: 5px;
                }
            {/literal}
        </style>
    </head>
    <body>
        <h1>An Exception ocurred :(</h1>
        <div>
            {nocache}
            {call name="PrintException" ex=$ex}
            {/nocache}
        </div>
    </body>
</html>
