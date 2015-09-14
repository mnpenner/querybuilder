<?php namespace QueryBuilder;

class SystemVariable implements IVar {
    /** @var string */
    protected $name;

    function __construct($alias) {
        $this->name = Util::joinIter('.',$alias);
        Util::assertName($this->name, true);
    }

    public function toSql(ISqlConnection $conn) {
        return '@@'.$this->name;
    }
}