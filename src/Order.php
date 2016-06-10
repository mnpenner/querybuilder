<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IOrder;
use QueryBuilder\Interfaces\ISqlConnection;

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

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        return $this->expr->_toSql($conn, $ctx) . ($this->asc ? '' : ' DESC');
    }
}