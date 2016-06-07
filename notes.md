### Render

Perhaps instead of calling `ISql->toSql()` we should do `$conn->render(ISql)`? This would be more consistent with templating libraries and other APIs.
Alternatively, we could also add a `$conn->execute` which would also accept an `ISql` to be rendered and executed in one swoop.
Also, `$conn->prepare` which would render the [parameterized] SQL and send it to the SQL server, and return back a statement for
later execution.

### Params

Need to figure out how to do params... I'm thinking each ISql should hold an array of params..perhaps they should be combined together
when the SQL is rendered? Or each param should be assigned a GUID so that they can be combined in any order... maybe
a Q\param() will accept a name and can be assigned a value at any time. Maybe at execution time, all the Q\params will be merged
into an array, and the user can supply values for any missing params via their name..? It should probably throw an exception
if the user creates two Q\params with the same name. If they want to do that, they need to use the same instance.

I think we need some kind of ConnStmt object. When you render a query using a connection object, it's swapped for a
ConnStmt which holds both the connection and collects up all the Param objects so that it can check them for consistency
(no duplicate names) and replace out the arrays correctly.


### Immutable

Making everything immutable would make the API easier to work with. Each fluent call would return a new instance.
e.g.

    public function distinct() {
        $clone = clone $this;
        $clone->distinct = true;
        return $clone;
    }

How expensive is this....is it worth it?

[This guy](http://evertpot.com/psr-7-issues/) talks a little bit about immutable fluent APIs. Some pros/cons to consider.


### TODO

- Add a RandAlias util.
- Add all MySQL functions. Compare w/ PostgreSQL functions. Probably will need to move them under MySQL namespace. ~~Perhaps make SimpleFunc abstract? Or don't...it's relatively harmless. It will also allow calling user-funcs. Maybe rename it to UserFunc then?~~
- operators: CASE, WHEN, THEN, ELSE. see http://dev.mysql.com/doc/refman/5.7/en/operator-precedence.html
- Literal value types: date, datetime, others? maybe even remove Value class
- Treat PHP literals like Value objects by default
- Figure out how to make "group-wise max" queries easy (do the double left join thing automatically...?)
- ITable and ITableAs should have two different methods -- getAlias() and toSql. This way it can used in both the "FROM" clause and "SELECT" fields (one with AS, one without)
- INSERT/UPDATE/REPLACE/CREATE TABLE/ALTER TABLE/... statements
- Split `Q` into a separate project.
    1. This query builder
    2. short concise helpers
    3. WebEngineX static autocompletes
- Make sure Params work nicely

### Static autocomplete files

```php
<?php
use QueryBuilder\Column;

abstract class Columns {
    /** @var Column[] */
    static $emrClient = [
        'id' => null,
    ];
}

$emrClient = [
    'id' => new Column('emr_client_id'),
];


// usage:
$qb->select(Columns::$emrClient['id']);
```

Or better yet, as seen in `wx2.php`


### Table aliasing

Allow creating a new table alias which can then be used to generate fully-qualified file names.

e.g.

    $u1 = new Table('users','u1'); // **if table alias is omitted, then a unique one will be generated** based on the table name (perhaps singularized)
    $u2 = new Table('users','u2');
    Stmt::select($u1, $u2)->fields($u1->col('name','creator_name'), $u2->col('name','editor_name')) // SELECT `u1`.`name` AS `creator_name, `u2`.`name` AS `editor_name FROM `users` AS `u1`, `users` AS `u2`

