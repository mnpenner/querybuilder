<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\IFieldAlias;

class FieldAlias implements IFieldAlias {
    use AliasTrait;
    use ExprTrait;
}