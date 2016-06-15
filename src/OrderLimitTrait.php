<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\IOrderByList;
use QueryBuilder\MySql\DataTypes\Numeric\UBigInt;
use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IOrder;
use QueryBuilder\Interfaces\ISqlConnection;

trait OrderLimitTrait {
    /** @var IOrder[] */
    protected $order = [];
    /** @var null|int */
    protected $limit;
    /** @var null|int */
    protected $offset;


    /**
     * Overwrite the ORDER BY clause.
     * 
     * @param IOrder[] $order
     * @return $this
     */
    public function setOrderBy(IOrder ...$order) {
        $this->order = $order;
        return $this;
    }

//    public function withOrderBy($fn) {
//        call_user_func($fn, $this->orderList);
//        return $this;
//    }
//
//    public function getOrderBy() {
//        return $this->orderList;
//    }

    /**
     * Append to ORDER BY clause.
     * 
     * @param Interfaces\IOrder[] ...$order
     * @return $this
     */
    public function orderBy(IOrder ...$order) {
        array_push($this->order, ...$order);
        return $this;
    }

    /**
     * Prepend to ORDER BY clause.
     * 
     * @param Interfaces\IOrder[] ...$order
     * @return $this
     */
    public function preOrderBy(IOrder ...$order) {
        array_unshift($this->order, ...$order);
        return $this;
    }

    /**
     * @param int|null $limit
     * @return $this
     */
    public function limit($limit) {
        $this->limit = $limit !== null ? (int)$limit : null;
        return $this;
    }

    /**
     * @param int|null $offset
     * @return $this
     */
    public function offset($offset) {
        $this->offset = $offset !== null ? (int)$offset : null;
        return $this;
    }

    protected function getOrderLimitSql(ISqlConnection $conn, array &$ctx) {
        $sb = [];
        if($this->order) {
            $sb[] = 'ORDER BY';
            $sb[] = implode(', ', array_map(function ($p) use ($conn, &$ctx) {
                /** @var IExpr $p */
                return $p->_toSql($conn,$ctx);
            }, $this->order));
        }
        if($this->limit !== null || $this->offset !== null) {
            $sb[] = 'LIMIT';
            $sb[] = $this->limit === null ? UBigInt::MAX_VALUE : $this->limit;
            if($this->offset !== null) {
                $sb[] = 'OFFSET';
                $sb[] = $this->offset;
            }
        }
        return implode(' ',$sb);
    }
}