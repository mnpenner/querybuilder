<?php namespace QueryBuilder\Nodes;

use QueryBuilder\IExpr;

class AndNode extends Node {
    function __construct(IExpr ...$children) {
        parent::__construct('AND', ...$children);
    }
}