<?php namespace QueryBuilder\Functions;
use QueryBuilder\ICharset;
use QueryBuilder\IExpr;
use QueryBuilder\Util;
use QueryBuilder\ISqlConnection;

class CharUsing implements IExpr {
    /** @var ICharset */
    protected $charset;
    /** @var IExpr[] */
    protected $params;

    function __construct(ICharset $charset, IExpr... $params) {
        $this->charset = $charset;
        $this->params = $params;
    }

    public function toSql(ISqlConnection $conn) {
        return 'CHAR('.implode(', ', array_map(function ($p) use ($conn) {
            /** @var IExpr $p */
            return $p->toSql($conn);
        }, $this->params)).' USING '.$this->charset->toSql($conn).')';
    }
}