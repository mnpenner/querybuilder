<?php namespace QueryBuilder;

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
    /** @var string[] */
    private $values;
    /** @var string */
    private $escapeChar;

    /**
     * @param string[] $values Escaped, not escaped, escaped, not escaped...
     * @param string $escapeChar Escape character
     * @throws \Exception
     */
    function __construct($values, $escapeChar=null) {
        $this->values = array_values($values);
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        $sb = [];
        foreach($this->values as $i=>$val) {
            if($i % 2 === 0) {
                $sb[] = $conn->escapeLikePattern($val, $this->escapeChar,$ctx);
            } else {
                $sb[] = $val;
            }
        }
        return $conn->quote(implode('',$sb), $ctx);
    }
}