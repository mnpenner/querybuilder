<?php namespace QueryBuilder;

class Join implements IJoin {
    /** @var string */
    protected $type;
    /** @var ITable */
    protected $table;
    /** @var IExpr */
    protected $where;

    function __construct($type, ITable $table, IExpr $where) {
        $this->type = Util::keyword($type);
        $this->table = $table;
        $this->where = $where;
    }

    /**
     * @param ISqlConnection $conn An active SQL database connection
     * @return string An SQL string
     */
    public function toSql(ISqlConnection $conn) {
        return $this->type.' '.$this->table->toSql($conn).' ON '.$this->where->toSql($conn);
    }
}