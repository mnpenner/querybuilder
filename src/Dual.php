<?php namespace QueryBuilder;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\ITable;

/**
 * DUAL dummy table.
 *
 * DUAL is purely for the convenience of people who require that all SELECT statements should have FROM and possibly other clauses. MySQL may ignore the clauses. MySQL does not require FROM DUAL if no tables are referenced.
 */
class Dual implements ITable {
    public function _toSql(ISqlConnection $conn, array &$ctx) {
        return 'DUAL';
    }
}