<?php namespace QueryBuilder;

class FieldAsAlias implements IField {
    /** @var IExpr */
    protected $field;
    /** @var IFieldAlias */
    protected $alias;

    function __construct(IExpr $field, IFieldAlias $alias) {
        $this->field = $field;
        $this->alias = $alias;
    }

    public function toSql(ISqlConnection $conn) {
        return $this->field->toSql($conn).' AS '.$this->alias->toSql($conn);
    }
}