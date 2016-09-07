<?php namespace QueryBuilder;
use QueryBuilder\Interfaces\ICharset;
use QueryBuilder\Interfaces\ICollation;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\IString;

/**
 * A string is a sequence of bytes or characters, enclosed within either single quote (“'”) or double quote (“"”) characters.
 *
 * @see https://dev.mysql.com/doc/refman/5.7/en/string-literals.html
 * @see https://dev.mysql.com/doc/refman/5.7/en/charset-literal.html
 */
class StringLiteral implements IString {
    use ExprTrait;

    /** @var string */
    protected $literal;
    /** @var ICharset */
    protected $charset;
    /** @var ICollation */
    protected $collation;

    /**
     * @param $literal String literal
     * @param \QueryBuilder\Interfaces\ICharset $charset Character set name. Formally called an introducer. It tells the parser, “the string that is about to follow uses character set X.” An introducer does not change the string to the introducer character set like CONVERT() would do. It does not change the string's value, although padding may occur.
     * @param \QueryBuilder\Interfaces\ICollation $collation
     * @throws \Exception
     */
    function __construct($literal, ICharset $charset=null, ICollation $collation=null) {
        if(!is_string($literal)) throw new \Exception("Literal must be a string");
        $this->literal = $literal;
        $this->charset = $charset;
        $this->collation = $collation;
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        $sql = '';
        if($this->charset) {
            $sql .= '_'.$this->charset->_toSql($conn, $ctx);
        }
        $sql .= $conn->quote($this->literal, $ctx);
        if($this->collation) {
            $sql .= ' COLLATE '.$this->collation->_toSql($conn, $ctx);
        }
        return $sql;
    }
}