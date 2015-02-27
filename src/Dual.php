<?php namespace QueryBuilder;

/**
 * DUAL dummy table.
 *
 * DUAL is purely for the convenience of people who require that all SELECT statements should have FROM and possibly other clauses. MySQL may ignore the clauses. MySQL does not require FROM DUAL if no tables are referenced.
 */
class Dual implements ITable {
    public function toSql(ISqlConnection $conn) {
        return 'DUAL';
    }
}