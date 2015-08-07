<?php namespace QueryBuilder;

/**
 * A string is a sequence of bytes or characters, enclosed within either single quote (“'”) or double quote (“"”) characters.
 *
 * @see https://dev.mysql.com/doc/refman/5.7/en/string-literals.html
 * @see https://dev.mysql.com/doc/refman/5.7/en/charset-literal.html
 */
class StringLiteral implements IValue {
    /** @var string */
    protected $literal;
    /** @var ICharset */
    protected $charset;
    /** @var ICollation */
    protected $collation;

    /**
     * @param $literal String literal
     * @param \QueryBuilder\ICharset $charset Character set name. Formally called an introducer. It tells the parser, “the string that is about to follow uses character set X.” An introducer does not change the string to the introducer character set like CONVERT() would do. It does not change the string's value, although padding may occur.
     * @param \QueryBuilder\ICollation $collation
     * @throws \Exception
     */
    function __construct($literal, ICharset $charset=null, ICollation $collation=null) {
        if(!is_string($literal)) throw new \Exception("Literal must be a string");
        $this->literal = $literal;
        $this->charset = $charset;
        $this->collation = $collation;
    }

    public function toSql(ISqlConnection $conn) {
        $sql = '';
        if($this->charset) {
            $sql .= '_'.$this->charset->toSql($conn);
        }
        $sql .= $conn->quote($this->literal);
        if($this->collation) {
            $sql .= ' COLLATE '.$this->collation->toSql($conn);
        }
        return $sql;
    }
}