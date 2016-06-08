<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\IVar;

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