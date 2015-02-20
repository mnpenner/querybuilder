Perhaps instead of calling ISql->toSql() we should do Conn->render(ISql)? This would be more consistent with templating libraries and other APIs.
Alternatively, we could also add a Conn->execute which would also accept an ISql to be rendered and executed in one swoop.
Also, Conn->prepare which would render the [parameterized] SQL and send it to the SQL server, and return back a statement for
later execution.

Need to figure out how to do params... I'm thinking each ISql should hold an array of params..perhaps they should be combined together
when the SQL is rendered? Or each param should be assigned a GUID so that they can be combined in any order... maybe
a Q\param() will accept a name and can be assigned a value at any time. Maybe at execution time, all the Q\params will be merged
into an array, and the user can supply values for any missing params via their name..? It should probably throw an exception
if the user creates two Q\params with the same name. If they want to do that, they need to use the same instance.