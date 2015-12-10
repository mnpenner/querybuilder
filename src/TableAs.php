<?php namespace QueryBuilder;

class TableAs implements ITableAs {
    /** @var Table */
    protected $table;
    /** @var ITableAlias */
    protected $alias;

    function __construct(Table $table, ITableAlias $alias) {
        $this->table = $table;
        $this->alias = $alias;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->table->toSql($conn).' AS '.$this->alias->toSql($conn);
    }
}