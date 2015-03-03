<?php namespace QueryBuilder;

class Order implements IOrder {
    const ASC = true;
    const DESC = false;

    /** @var IExpr */
    protected $expr;
    /** @var bool */
    protected $asc;

    /**
     * @param IExpr $expr Order by the result of the expression
     * @param bool $asc Direction; Order::ASC or Order::DESC
     */
    function __construct(IExpr $expr, $asc=Order::ASC) {
        $this->expr = $expr;
        $this->asc = (bool)$asc;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->expr->toSql($conn) . ($this->asc ? '' : ' DESC');
    }
}