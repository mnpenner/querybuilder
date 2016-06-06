<?php namespace QueryBuilder;

class TableAs implements ITableAs {
    /** @var ITable */
    protected $table;
    /** @var ITableAlias */
    protected $alias;

    function __construct(ITable $table, ITableAlias $alias) {
        $this->table = $table;
        $this->alias = $alias;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->table->toSql($conn).' AS '.$this->alias->toSql($conn);
    }
}