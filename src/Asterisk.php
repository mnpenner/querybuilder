<?php
namespace QueryBuilder;

class Asterisk implements IExpr {
    /** @var string */
    protected $databaseName;
    /** @var string */
    protected $tableName;

    /**
     * @param string $database Database name, or table name if 2nd arg is omitted
     * @param string $table Table name
     */
    function __construct($database=null, $table=null) {
        switch(func_num_args()) {
            case 0:
                $this->databaseName = null;
                $this->tableName = null;
                break;
            case 1:
                $this->databaseName = null;
                $this->tableName = $database;
                break;
            case 2:
                $this->databaseName = $database;
                $this->tableName = $table;
                break;
            default:
                throw new \BadMethodCallException("Expected 0-2 args");
        }
    }

    /**
     * @return bool
     */
    public function isUnqualified() {
        return !strlen($this->databaseName) && !strlen($this->tableName);
    }

    public static function value() { // FIXME: perhaps this should be removed..? it can be added as a helper instead
        static $value;
        if(!$value) $value = new self;
        return $value;
    }

    public function toSql(ISqlConnection $conn) {
        $parts = [];
        if(strlen($this->databaseName)) $parts[] = $conn->id($this->databaseName);
        if(strlen($this->tableName)) $parts[] = $conn->id($this->tableName);
        $parts[] = '*';
        return implode('.', $parts);
    }
}
