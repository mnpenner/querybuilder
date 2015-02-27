<?php namespace QueryBuilder\Statements;

class UnionAll extends AbstractUnion {
    public function getType() {
        return 'UNION ALL';
    }
}