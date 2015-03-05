Perhaps instead of calling ISql->toSql() we should do Conn->render(ISql)? This would be more consistent with templating libraries and other APIs.
Alternatively, we could also add a Conn->execute which would also accept an ISql to be rendered and executed in one swoop.
Also, Conn->prepare which would render the [parameterized] SQL and send it to the SQL server, and return back a statement for
later execution.

---

Need to figure out how to do params... I'm thinking each ISql should hold an array of params..perhaps they should be combined together
when the SQL is rendered? Or each param should be assigned a GUID so that they can be combined in any order... maybe
a Q\param() will accept a name and can be assigned a value at any time. Maybe at execution time, all the Q\params will be merged
into an array, and the user can supply values for any missing params via their name..? It should probably throw an exception
if the user creates two Q\params with the same name. If they want to do that, they need to use the same instance.

---
Making everything immutable would make the API easier to work with. Each fluent call would return a new instance.
e.g.

    public function distinct() {
        $clone = clone $this;
        $clone->distinct = true;
        return $clone;
    }

How expensive is this....is it worth it?

---

Add a RandAlias util.


Add all MySQL functions. Compare w/ PostgreSQL functions. Probably will need to move them under MySQL namespace. Perhaps make SimpleFunc abstract? Or don't...it's relatively harmless. It will also allow calling user-funcs. Maybe rename it to UserFunc then?


TODO: operators: CASE, WHEN, THEN, ELSE. see http://dev.mysql.com/doc/refman/5.7/en/operator-precedence.html


---

[This guy](http://evertpot.com/psr-7-issues/) talks a little bit about immutable fluent APIs. Some pros/cons to consider.