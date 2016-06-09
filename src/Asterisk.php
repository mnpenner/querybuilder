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

    public function _toSql(ISqlConnection $conn, \QueryBuilder\Interfaces\IDict $ctx) {
        return ($this->table ? $this->table->_toSql($conn, $ctx) . '.' : '') . '*';
    }
}
