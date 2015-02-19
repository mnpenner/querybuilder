<?php namespace QueryBuilder;

class ColumnAlias implements ISelectExpr {
    /** @var ColumnSpec */
    protected $identifier;
    /** @var string */
    protected $alias;

    function __construct(ColumnSpec $identifier, $alias) {
        $this->identifier = $identifier;
        $this->alias = $alias;
    }

    public function toSql(SqlConnection $sql) {
        return $this->identifier->toSql($sql).' AS '.$sql->id($this->alias);
    }
}