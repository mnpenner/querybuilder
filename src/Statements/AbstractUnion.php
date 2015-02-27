<?php namespace QueryBuilder\Statements;

use QueryBuilder\CopyTrait;
use QueryBuilder\ISelect;
use QueryBuilder\ISqlConnection;
use QueryBuilder\IStatement;
use QueryBuilder\OrderLimitTrait;

abstract class AbstractUnion implements ISelect {
    use OrderLimitTrait;
    use CopyTrait;

    /** @var ISelect[] */
    protected $selects;

    function __construct(ISelect ...$selects) {
        $this->selects = $selects;
    }

    public function push(ISelect ...$selects) {
        array_push($this->selects, ...$selects);
        return $this;
    }


    /**
     * @return string
     */
    abstract public function getType();

    public function toSql(ISqlConnection $conn) {
        if(!$this->selects) return '/* empty '.$this->getType().' */'; // or should this throw an exception?
        $sb = [];

        $sb[] = '('.implode(")\n".$this->getType()."\n(",array_map(function($select) use ($conn) {
                /** @var ISelect $select */
                return $select->toSql($conn);
            }, $this->selects)).')';

        $orderLimitSql = $this->getOrderLimitSql();
        if(strlen($orderLimitSql)) $sb[] = "\n".$orderLimitSql;

        return implode(' ',$sb);
    }
}