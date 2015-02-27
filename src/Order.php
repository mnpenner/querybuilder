<?php namespace QueryBuilder;

class Order implements IOrder {
    const ASC = true;
    const DESC = false;

    /** @var IExpr */
    protected $expr;
    /** @var bool */
    protected $dirAsc;

    /**
     * @param IExpr $expr Order by the result of the expression
     * @param bool $dirAsc Direction; Order::ASC or Order::DESC
     */
    function __construct(IExpr $expr, $dirAsc=Order::ASC) {
        $this->expr = $expr;
        $this->dirAsc = (bool)$dirAsc;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->expr->toSql($conn) . ($this->dirAsc ? '' : ' DESC');
    }
}