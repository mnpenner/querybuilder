<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\IVar;

class UserVariable implements IVar {
    /** @var string */
    protected $name;

    function __construct($alias) {
        Util::assertName($alias);
        $this->name = (string)$alias;
    }

    public function _toSql(ISqlConnection $conn, \QueryBuilder\Interfaces\IDict $ctx) {
        return '@'.$this->name;
    }
}