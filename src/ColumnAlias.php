<?php namespace QueryBuilder;

class ColumnAlias implements IColumn {
    /** @var Column */
    protected $identifier;
    /** @var string */
    protected $alias;

    function __construct(Column $identifier, $alias) {
        $this->identifier = $identifier;
        $this->alias = $alias;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->identifier->toSql($conn).' AS '.$conn->id($this->alias);
    }
}