<?php
namespace QueryBuilder;

class Asterisk implements IField {
    /** @var IAliasOrTable */
    protected $table;

    /**
     * @param IAliasOrTable $table
     */
    function __construct(IAliasOrTable $table=null) {
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
