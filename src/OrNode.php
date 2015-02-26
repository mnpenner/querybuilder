<?php namespace QueryBuilder;

class OrNode extends Node {
    function __construct(IExpr ...$children) {
        parent::__construct('OR', ...$children);
    }
}