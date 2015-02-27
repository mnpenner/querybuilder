<?php namespace QueryBuilder;

class FieldAlias implements IField {
    /** @var IExpr */
    protected $field;
    /** @var IAlias */
    protected $alias;

    function __construct(IExpr $field, IAlias $alias) {
        $this->field = $field;
        $this->alias = $alias;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->field->toSql($conn).' AS '.$this->alias->toSql($conn);
    }
}