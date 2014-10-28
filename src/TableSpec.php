<?php
namespace QueryBuilder;

/**
 * Represents an (optionally) fully-qualified table name.
 */
class TableSpec implements ISchema {
    protected $schemaName;
    protected $tableName;

    function __construct($schema, $table=null) {
        $args = func_get_args();
        switch(count($args)) {
            case 1:
                $this->tableName = $args[0];
                break;
            case 2:
                list($this->schemaName, $this->tableName) = $args;
                break;
            default:
                throw new \BadMethodCallException("Expected 1 or 2 args");
        }
    }

    public function toSql(SqlConnection $sql) {
        return implode('.', array_map([$sql, 'id'], array_filter([$this->schemaName, $this->tableName], 'strlen')));
    }

}