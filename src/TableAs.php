<?php namespace QueryBuilder;

class TableAs implements ITable {
    /** @var Table */
    protected $table;
    /** @var IFieldAlias */
    protected $alias;

    function __construct(Table $table, IFieldAlias $alias) {
        $this->table = $table;
        $this->alias = $alias;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->table->toSql($conn).' AS '.$this->alias->toSql($conn);
    }
}