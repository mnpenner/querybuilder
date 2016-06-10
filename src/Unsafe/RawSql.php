<?php namespace QueryBuilder\Unsafe;

use QueryBuilder\Interfaces\ISqlFrag;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\SqlFrag;

class RawSql extends SqlFrag {
    /** @var string */
    protected $sql;

    /**
     * @param string $sql Raw SQL.
     */
    function __construct($sql) {
        $this->sql = (string)$sql;
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        return $this->sql;
    }
}