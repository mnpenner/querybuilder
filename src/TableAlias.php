<?php namespace QueryBuilder;

class TableAlias implements ISchema {
    /** @var TableSpec */
    protected $identifier;
    /** @var string */
    protected $alias;

    function __construct(TableSpec $identifier, $alias) {
        $this->identifier = $identifier;
        $this->alias = $alias;
    }

    public function toSql(SqlConnection $sql) {
        return $this->identifier->toSql($sql).' AS '.$sql->id($this->alias);
    }
}