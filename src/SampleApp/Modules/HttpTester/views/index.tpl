<!DOCTYPE html>
<html>
    <head>
        <title>Http requests testster</title>
    </head>
    <body>
        <form action="{$action}" method="post">
            <fieldset>
                <legend>URI</legend>

                <label>Root:</label>
                <input type="text" placeholder="http://" {bind to=""}/>
                <label>Service:</label>
                <input type="text" placeholder="EntityName/Other/stuff" {bind to=""} />
                <label>Method</label>
                <select {bind to=""}>
                    <option>GET</option>
                    <option>POST</option>
                    <option>PUT</option>
                    <option>DELETE</option>
                </select>
            </fieldset>
            <fieldset>
                <legend>Header variables</legend>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Value</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" value="Content-type" {bind to=""} />
                            </td>
                            <td>
                                <input type="text" placeholder="mime/type" {bind to=""} />
                            </td>
                            <td>
                                <input type="button" value="x"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" value="Accept" {bind to=""} />
                            </td>
                            <td>
                                <input type="text" placeholder="mime/type" {bind to=""} />
                            </td>
                            <td>
                                <input type="button" value="x"/>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <input type="button" value="Add" />
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </fieldset>
            <fieldset>
                <legend>Request body (payload)</legend>
                <textarea></textarea>
                <div>
                    <button>Clear</button>
                </div>
            </fieldset>
            <input type="submit" value="Send" />
            <input type="button" value="Bookmark" />
        </form>
    </body>
</html>