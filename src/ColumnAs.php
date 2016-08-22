<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\IColumn;
use QueryBuilder\Interfaces\IField;
use QueryBuilder\Interfaces\IFieldAlias;
use QueryBuilder\Interfaces\ISqlConnection;

class ColumnAs implements IField {
    /** @var IColumn */
    protected $column;
    /** @var IFieldAlias */
    protected $alias;

    function __construct(IColumn $column, IFieldAlias $alias) {
        $this->column = $column;
        $this->alias = $alias;
    }

    public function getColumn() {
        return $this->column;
    }

    public function getAlias() {
        return $this->alias;
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        return $this->column->_toSql($conn, $ctx).' AS '.$this->alias->_toSql($conn, $ctx);
    }
}