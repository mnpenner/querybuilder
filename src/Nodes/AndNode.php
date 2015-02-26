<?php namespace QueryBuilder\Nodes;

use QueryBuilder\IExpr;
use QueryBuilder\Node;

class AndNode extends Node {
    function __construct(IExpr ...$children) {
        parent::__construct('AND', ...$children);
    }
}