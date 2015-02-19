<?php namespace QueryBuilder;

class RawSql implements ISql {
    /** @var string */
    protected $sql;

    /**
     * @param string $sql Raw SQL.
     */
    function __construct($sql) {
        $this->sql = $sql;
    }

    public function toSql(SqlConnection $sql) {
        return $this->sql;
    }
}