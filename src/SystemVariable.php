<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\IVar;

class SystemVariable implements IVar {
    use ExprTrait;

    /** @var string */
    protected $name;

    function __construct($alias) {
        $this->name = Util::joinIter('.',$alias);
        Util::assertName($this->name, true);
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        return '@@'.$this->name;
    }
}