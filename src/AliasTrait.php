<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\ISqlConnection;

trait AliasTrait {
    /** @var string */
    protected $alias;

    function __construct($alias) {
        $this->alias = (string)$alias;
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        return $conn->id($this->alias, $ctx);
    }
}

__halt_compiler();

http://dev.mysql.com/doc/refman/5.7/en/problems-with-alias.html

- In the select list of a query, a quoted column alias can be specified using identifier or string quoting characters
- Elsewhere in the statement, quoted references to the alias must use identifier quoting or the reference is treated as a string literal. 