<?php namespace QueryBuilder\Operator;

// http://dev.mysql.com/doc/refman/5.7/en/charset-collate.html

use QueryBuilder\AbstractPolyadicOperator;
use QueryBuilder\Interfaces\ICollation;
use QueryBuilder\Interfaces\IExpr;

class Collate extends AbstractPolyadicOperator {

    public function __construct(IExpr $left, ICollation $right) {
        parent::__construct($left, $right);
    }

    public function getOperator() {
        return 'COLLATE';
    }

    public function getPrecedence() {
        return 160;
    }
    
    public function getAssociativity() {
        return Associativity::LEFT_ASSOCIATIVE; // I don't know how to verify this
    }
}

__halt_compiler();

TODO:
Add support for this crap:

SELECT *
FROM t1
WHERE _latin1 'Müller' COLLATE latin1_german2_ci = k;