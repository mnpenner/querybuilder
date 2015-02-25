<?php namespace QueryBuilder;

/**
 * DUAL is purely for the convenience of people who require that all SELECT statements should have FROM and possibly other clauses. MySQL may ignore the clauses. MySQL does not require FROM DUAL if no tables are referenced.
 *
 * @return ITable
 */
function dual() {
    return Dual::value();
}

/**
 * A select list consisting only of a single unqualified * can be used as shorthand to select all columns from all tables.
 *
 * Use of an unqualified * with other items in the select list may produce a parse error. To avoid this problem, use a qualified tbl_name.* reference.
 *
 * @return IExpr
 */
function allColumns() {
    return Asterisk::value();
}

/**
 * Creates a new "SELECT * FROM $tableRef" statement.
 *
 * @param ITable $tableRef
 * @return Select
 */
function selectAll(ITable $tableRef=null) {
    return (new Select())->fields(Asterisk::value())->from($tableRef);
}

/**
 * Creates a new "SELECT ... FROM $tableRef" statement
 *
 * @param ITable $tableRef
 * @return Select
 */
function fromTable(ITable $tableRef) {
    return (new Select())->from($tableRef);
}

/**
 * Returns a new EXISTS(SELECT ...) subquery.
 *
 * @return SubQuery
 */
function exists() {
    return new SubQuery('EXISTS');
}


/**
 * Return the given object. Useful for chaining.
 *
 * e.g. with(clone $selectStmt)->select(...)
 *
 * @param mixed $obj
 * @return mixed
 */
function with($obj) {
    return $obj;
}

/**
 * Returns a clone of the given object. Useful for chaining.
 *
 * e.g. copy($selectStmt)->select(...)
 *
 * @param mixed $obj
 * @return mixed
 */
function copy($obj) {
    return clone $obj;
}