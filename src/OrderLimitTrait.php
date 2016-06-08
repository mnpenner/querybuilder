<?php namespace QueryBuilder;

use QueryBuilder\MySql\DataTypes\Numeric\UBigInt;
use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IOrder;
use QueryBuilder\Interfaces\ISqlConnection;

trait OrderLimitTrait {
    /** @var IOrder[] */
    protected $order;
    /** @var null|int */
    protected $limit;
    /** @var null|int */
    protected $offset;


    public function orderBy(IOrder ...$order) {
        $this->order = $order;
        return $this;
    }

    public function appendOrderBy(IOrder ...$order) {
        array_push($this->order, ...$order);
        return $this;
    }

    public function prependOrderBy(IOrder ...$order) {
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

    protected function getOrderLimitSql(ISqlConnection $conn) {
        $sb = [];
        if($this->order) {
            $sb[] = 'ORDER BY';
            $sb[] = implode(', ', array_map(function ($p) use ($conn) {
                /** @var IExpr $p */
                return $p->toSql($conn);
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