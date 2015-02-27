<?php namespace QueryBuilder;

class TableAlias implements ITable {
    /** @var Table */
    protected $table;
    /** @var IAlias */
    protected $alias;

    function __construct(Table $table, IAlias $alias) {
        $this->table = $table;
        $this->alias = $alias;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->table->toSql($conn).' AS '.$this->alias->toSql($conn);
    }
}