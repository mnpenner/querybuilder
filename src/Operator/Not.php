<?php namespace QueryBuilder\Operator;
use QueryBuilder\UnaryOperator;

/**
 * Logical NOT.
 *
 * Assumes HIGH_NOT_PRECEDENCE is disabled.
 */
class Not extends UnaryOperator {
    public function getOperator() {
        return 'NOT';
    }

    public function getPrecedence() {
        return 50;
    }
}

__halt_compiler();

mysql> SET sql_mode = '';
mysql> SELECT NOT 1 BETWEEN -5 AND 5;
        -> 0
mysql> SET sql_mode = 'HIGH_NOT_PRECEDENCE';
mysql> SELECT NOT 1 BETWEEN -5 AND 5;
        -> 1