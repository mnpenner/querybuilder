<?php namespace QueryBuilder\Statements;

use QueryBuilder\ISelect;
use QueryBuilder\ISqlConnection;
use QueryBuilder\IStatement;
use QueryBuilder\OrderLimitTrait;

abstract class AbstractUnion implements ISelect {
    use OrderLimitTrait;

    /** @var ISelect[] */
    protected $selects;

    function __construct(ISelect ...$selects) {
        $this->selects = $selects;
    }

    public function push(ISelect ...$selects) {
        array_push($this->selects, ...$selects);
    }


    /**
     * @return string
     */
    abstract public function getType();

    public function toSql(ISqlConnection $conn) {
        if(!$this->selects) return '/* empty '.$this->getType().' */'; // or should this throw an exception?
        $sb = [];


        if($this->limit !== null || $this->offset !== null) {
            $sb[] = 'LIMIT';
            $sb[] = $this->limit === null ? '18446744073709551615' : $this->limit;
            if($this->offset !== null) {
                $sb[] = 'OFFSET';
                $sb[] = $this->offset;
            }
        }
        return implode(' ',$sb);
    }
}