<?php namespace QueryBuilder;

class Alias implements IAlias {
    /** @var string */
    protected $alias;

    function __construct($alias) {
        $this->alias = (string)$alias;
    }

    public function toSql(ISqlConnection $conn) {
        return $conn->id($this->alias);
    }
}