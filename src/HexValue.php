<?php namespace QueryBuilder;

class HexValue implements IValue {
    /** @var int|string */
    protected $value;

    /**
     * @param int|string
     * @throws \Exception
     */
    function __construct($value) {
        if(!(is_int($value) || is_string($value))) throw new \Exception("Value must be int or string");
        $this->value = $value;
    }

    public function toSql(ISqlConnection $conn) {
        return '0x' . strtoupper(is_int($this->value)
            ? dechex($this->value)
            : bin2hex($this->value)
        );

    }
}