<?php namespace QueryBuilder\Nodes;

use QueryBuilder\IExpr;
use QueryBuilder\Node;

class OrNode extends Node {
    function __construct(IExpr ...$children) {
        parent::__construct('OR', ...$children);
    }
}