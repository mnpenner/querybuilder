<?php namespace QueryBuilder\Statements;

class Union extends AbstractUnion {
    public function getType() {
        return 'UNION';
    }
}