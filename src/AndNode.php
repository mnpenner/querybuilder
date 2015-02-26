<?php namespace QueryBuilder;

class AndNode extends Node {
    function __construct(IExpr ...$children) {
        parent::__construct('AND', ...$children);
    }
}