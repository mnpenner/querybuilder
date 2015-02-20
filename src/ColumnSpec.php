<?php namespace QueryBuilder;

/**
 * Represents an (optionally) fully-qualified column name.
 */
class ColumnSpec implements IExpr {
    protected $schemaName;
    protected $tableName;
    protected $columnName;

    function __construct($schema, $table=null, $column=null) {
        $args = func_get_args();
        switch(count($args)) {
            case 1:
                $this->columnName = $args[0];
                break;
            case 2:
                list($this->tableName, $this->columnName) = $args;
                break;
            case 3:
                list($this->schemaName, $this->tableName, $this->columnName) = $args;
                break;
            default:
                throw new \BadMethodCallException("Expected 1-3 args");
        }
    }

    public function toSql(SqlConnection $conn) {
        return implode('.', array_map([$conn, 'id'], array_filter([$this->schemaName, $this->tableName, $this->columnName], 'strlen')));
    }

}