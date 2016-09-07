<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IField;
use QueryBuilder\Interfaces\IFieldAlias;
use QueryBuilder\Interfaces\ISqlConnection;

class ExprAs implements IField {
    /** @var IExpr */
    protected $expr;
    /** @var IFieldAlias */
    protected $alias;

    function __construct(IExpr $expr, IFieldAlias $alias) {
        $this->expr = $expr;
        $this->alias = $alias;
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        return $this->expr->_toSql($conn, $ctx).' AS '.$this->alias->_toSql($conn, $ctx);
    }

    public function getExpr() {
        return $this->expr;
    }

    /**
     * @return IFieldAlias
     */
    public function getAlias() {
        return $this->alias;
    }
}