<?php namespace QueryBuilder;

class TableAlias implements ITable {
    /** @var Table */
    protected $identifier;
    /** @var string */
    protected $alias;

    function __construct(Table $identifier, $alias) {
        $this->identifier = $identifier;
        $this->alias = $alias;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->identifier->toSql($conn).' AS '.$conn->id($this->alias);
    }
}