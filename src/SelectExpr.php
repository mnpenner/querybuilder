<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\ISelect;
use QueryBuilder\Interfaces\ISqlConnection;

class SelectExpr implements IExpr {
    use ExprTrait;

    /** @var ISelect */
    protected $select;

    function __construct(ISelect $select) {
        $this->select = $select;
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        // TODO: check if limit > 1 or fields > 1? usage: select (select c1 from t1) <-- only 1 column and 1 record is allowed
        // limit doesn't need to explicitly set to 1 though... it's OK if the query is guaranteed to only return 1 result (via unique or primary constraints)
        return '('.$this->select->_toSql($conn, $ctx).')';
    }
}