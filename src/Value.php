<?php namespace QueryBuilder;

class Value implements IValue {
    protected $value;
    protected $name;

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