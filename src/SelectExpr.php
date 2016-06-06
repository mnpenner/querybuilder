<?php namespace QueryBuilder;

class SelectExpr implements IExpr {
    /** @var ISelect */
    protected $select;

    function __construct(ISelect $select) {
        $this->select = $select;
    }

    public function toSql(ISqlConnection $conn) {
        // TODO: check if limit > 1 or fields > 1? usage: select (select c1 from t1) <-- only 1 column and 1 record is allowed
        return '('.$this->select->toSql($conn).')';
    }
}