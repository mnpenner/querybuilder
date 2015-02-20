<?php namespace QueryBuilder;

class RawSql implements ISql {
    /** @var string */
    protected $sql;

    /**
     * @param string $sql Raw SQL.
     */
    function __construct($sql) {
        $this->sql = (string)$sql;
    }

    public function toSql(SqlConnection $conn) {
        return $this->sql;
    }
}