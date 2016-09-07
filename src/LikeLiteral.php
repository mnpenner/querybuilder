<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IField;
use QueryBuilder\Interfaces\IFieldAlias;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\IValue;

/**
 * Allows you to write language-agnostic LIKE queries.
 *
 * e.g.: new Like($expr, new LikeLiteral([$str,'%']))
 *
 * This creates a 'starts with' query, where $str can contain wildcard characters that will be escaped at render time.
 *
 * Even array elements will be escaped, odd array elements will not be. Thus the equivalent 'ends with' query would
 * look like `['','%',$str]` (the first element is empty because it would have been escaped).
 */
class LikeLiteral implements IValue {
    use ExprTrait;

    /** @var string[] */
    private $values;
    /** @var string */
    private $escapeChar;

    /**
     * @param string[] $values Escaped, not escaped, escaped, not escaped...
     * @param string $escapeChar Escape character
     * @throws \Exception
     */
    function __construct(array $values, $escapeChar=null) {
        foreach($values as $i=>$val) {
            if(!is_string($val)) {
                throw new \Exception(__CLASS__.' expects an array of strings for values; got '.Util::getType($val).' at position '.$i);
            }
        }
        $this->values = array_values($values);
        $this->escapeChar = $escapeChar;
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        $sb = [];
        foreach($this->values as $i=>$val) {
            if($i % 2 === 0) {
                $sb[] = $conn->escapeLikePattern($val, $this->escapeChar, $ctx);
            } else {
                $sb[] = $val;
            }
        }
        $str = $conn->quote(implode('',$sb), $ctx);
        if(strlen($this->escapeChar)) {
            $str .= ' ESCAPE '.$conn->quote($this->escapeChar, $ctx);
        }
        return $str;
    }
}