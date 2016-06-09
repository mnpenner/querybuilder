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
     * @param \ArrayAccess|IDict|Interfaces\IDict $ctx
     * @return string An SQL string
     */
    public function _toSql(ISqlConnection $conn, \QueryBuilder\Interfaces\IDict $ctx) {
        $sql = $this->type.' '.$this->table->_toSql($conn, $ctx);
        if($this->where) $sql .= ' ON '.$this->where->_toSql($conn, $ctx); // the "ON" portion isn't needed with subqueries and natural joins
        return $sql;
    }
}