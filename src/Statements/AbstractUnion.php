<?php namespace QueryBuilder\Statements;

use QueryBuilder\Interfaces\ISelect;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\IStatement;
use QueryBuilder\Interfaces\ITableAlias;
use QueryBuilder\OrderByList;
use QueryBuilder\OrderLimitTrait;
use QueryBuilder\SelectTable;
use QueryBuilder\AbstractStatement;

abstract class AbstractUnion extends AbstractStatement implements ISelect {
    use OrderLimitTrait;

    /** @var ISelect[] */
    protected $selects;

    function __construct(ISelect ...$selects) {
        $this->selects = $selects;
    }

    public function push(ISelect ...$selects) {
        array_push($this->selects, ...$selects);
        return $this;
    }

    public function toTable(ITableAlias $alias) {
        return new SelectTable($this, $alias);
    }

    /**
     * @return string
     */
    abstract public function getType();

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        if(!$this->selects) return '/* empty '.$this->getType().' */'; // or should this throw an exception?
        $sb = [];

        $sb[] = implode("\n".$this->getType()."\n",array_map(function($select) use ($conn, &$ctx) {
                /** @var ISelect $select */
                return $select->_toSql($conn,$ctx);
            }, $this->selects));

        $orderLimitSql = $this->getOrderLimitSql($conn, $ctx);
        if(strlen($orderLimitSql)) $sb[] = "\n".$orderLimitSql;

        return implode(' ',$sb);
    }
}