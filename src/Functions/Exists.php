<?php namespace QueryBuilder\Functions;

use QueryBuilder\IExpr;
use QueryBuilder\ISelect;
use QueryBuilder\ISqlConnection;


// fixme: move to funcs
class Exists implements IExpr {
    /** @var ISelect */
    protected $select;

    function __construct(ISelect $select) {
        $this->select = $select;
    }

    /**
     * @param ISqlConnection $conn An active SQL database connection
     *
     * @return string An SQL string
     */
    public function toSql(ISqlConnection $conn) {
        return 'EXISTS('.$this->select->toSql($conn).')';
    }
}