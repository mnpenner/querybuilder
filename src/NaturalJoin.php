<?php namespace QueryBuilder;

class NaturalJoin implements IJoin {
    /** @var string|null */
    protected $direction;
    /** @var ITable */
    protected $table;

    /**
     * @param ITable $table
     * @param string|null $direction `null`, "LEFT", "LEFT OUTER", "RIGHT OUTER"
     */
    function __construct(ITable $table, $direction=null) {
        $this->direction = Util::keyword($direction);
        $this->table = $table;
    }

    /**
     * @param ISqlConnection $conn An active SQL database connection
     * @return string An SQL string
     */
    public function toSql(ISqlConnection $conn) {
        return 'NATURAL ' . ($this->direction ? $this->direction . ' ' : '') . 'JOIN ' . $this->table->toSql($conn);
    }
}