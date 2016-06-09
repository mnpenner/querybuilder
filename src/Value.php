<?php namespace QueryBuilder;


// fixme: rename to "Literal" to match docs? https://dev.mysql.com/doc/refman/5.7/en/literals.html
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\IValue;

class Value implements IValue {
    /** @var array|\DateTime|float|int|string */
    protected $value;

    /**
     * @param int|float|string|array|\DateTime $value
     * @throws \Exception
     */
    function __construct($value) {
        $this->value = $value;
    }

    public function _toSql(ISqlConnection $conn, \QueryBuilder\Interfaces\IDict $ctx) {
        return $conn->quote($this->value, $ctx);
    }
}