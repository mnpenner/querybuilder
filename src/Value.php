<?php namespace QueryBuilder;


// fixme: rename to "Literal" to match docs? https://dev.mysql.com/doc/refman/5.7/en/literals.html
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

    public function toSql(ISqlConnection $conn) {
        return $conn->quote($this->value);
    }
}