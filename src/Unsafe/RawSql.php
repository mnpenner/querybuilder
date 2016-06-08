<?php namespace QueryBuilder\Unsafe;

use QueryBuilder\Interfaces\ISqlFrag;
use QueryBuilder\Interfaces\ISqlConnection;

class RawSql implements ISqlFrag {
    /** @var string */
    protected $sql;

    /**
     * @param string $sql Raw SQL.
     */
    function __construct($sql) {
        $this->sql = (string)$sql;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->sql;
    }
}