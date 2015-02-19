<?php namespace QueryBuilder;

/**
 * DUAL is purely for the convenience of people who require that all SELECT statements should have FROM and possibly other clauses. MySQL may ignore the clauses. MySQL does not require FROM DUAL if no tables are referenced.
 *
 * @return ISchema
 */
function dual() {
    static $dual;
    if(!$dual) $dual = new RawSchema('DUAL');
    return $dual;
}

/**
 * @return ISelectExpr
 */
function wild() {
    static $wild;
    if(!$wild) $wild = new RawSelectExpr('*');
    return $wild;
}