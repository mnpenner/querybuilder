<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IJoin;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\ITable;
use QueryBuilder\Interfaces\ITableAs;
use QueryBuilder\Util;

class Join implements IJoin {
    /** @var string */
    protected $type;
    /** @var ITable */
    protected $table;
    /** @var IExpr|null */
    protected $where;

    function __construct($type, ITableAs $table, IExpr $where=null) {
        $this->type = Util::keyword($type);
        $this->table = $table;
        $this->where = $where;
    }

    /**
     * @param ISqlConnection $conn An active SQL database connection
     * @return string An SQL string
     */
    public function toSql(ISqlConnection $conn) {
        $sql = $this->type.' '.$this->table->toSql($conn);
        if($this->where) $sql .= ' ON '.$this->where->toSql($conn); // the "ON" portion isn't needed with subqueries and natural joins
        return $sql;
    }
}