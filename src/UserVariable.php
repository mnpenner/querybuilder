<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\IVar;

class UserVariable implements IVar {
    use ExprTrait;

    /** @var string */
    protected $name;

    function __construct($alias) {
        Util::assertName($alias);
        $this->name = (string)$alias;
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        return '@'.$this->name;
    }
}