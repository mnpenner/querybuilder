<?php namespace QueryBuilder;

class UserVariable implements IVar {
    /** @var string */
    protected $name;

    function __construct($alias) {
        Util::assertName($alias);
        $this->name = (string)$alias;
    }

    public function toSql(ISqlConnection $conn) {
        return '@'.$this->name;
    }
}