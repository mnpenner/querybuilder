<?php
namespace QueryBuilder;

use QueryBuilder\Interfaces\IField;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\ITableOrTableAlias;

class Asterisk implements IField {
    /** @var ITableOrTableAlias */
    protected $table;

    /**
     * @param ITableOrTableAlias $table
     */
    function __construct(ITableOrTableAlias $table=null) {
        $this->table = $table;
    }

    /**
     * @return bool
     */
    public function isUnqualified() {
        return !$this->table;
    }

    public function toSql(ISqlConnection $conn) {
        return ($this->table ? $this->table->toSql($conn) . '.' : '') . '*';
    }
}
