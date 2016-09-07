<?php namespace QueryBuilder;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\IValue;

/**
 * @see https://dev.mysql.com/doc/refman/5.7/en/hexadecimal-literals.html
 */
class HexLiteral implements IValue {
    use ExprTrait;
    /** @var string */
    protected $hex;

    /**
     * @param int|string $value
     * @param bool $is_hex_string True if value is already hex encoded, false to perform hex encoding automatically
     * @throws \Exception
     */
    function __construct($value, $is_hex_string=false) {
        if($is_hex_string) {
            if(!is_string($value)) {
                throw new \Exception("Hex value must be a string");
            }
            if(!preg_match('#(?J)(?:(X\')(?:[0-9a-f]{2})+\'|(0x)?[0-9a-f]+)\z#iA',$value,$match)) {
                throw new \Exception("Invalid hex format: $value");
            }
            if(!isset($match[1])) {
                $this->hex = '0x'.$match[0];
            } else {
                $this->hex = $match[0];
            }
        } else {
            if (!(is_int($value) || is_string($value))) {
                throw new \Exception("Value must be int or string");
            }
            $this->hex = '0x' . strtoupper(is_int($value)
                    ? dechex($value)
                    : bin2hex($value)
                );
        }
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        return $this->hex;

    }
}