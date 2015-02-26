<?php namespace QueryBuilder\Nodes;

use QueryBuilder\IExpr;

class OrNode extends Node {
    function __construct(IExpr ...$children) {
        parent::__construct('OR', ...$children);
    }
}