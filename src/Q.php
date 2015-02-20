<?php namespace QueryBuilder;

/**
 * DUAL is purely for the convenience of people who require that all SELECT statements should have FROM and possibly other clauses. MySQL may ignore the clauses. MySQL does not require FROM DUAL if no tables are referenced.
 *
 * @return ITableRef
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
 * @param ITableRef $tableRef
 * @return SelectStmt
 */
function selectAll(ITableRef $tableRef=null) {
    return (new SelectStmt())->select(Asterisk::value())->from($tableRef);
}

/**
 * Creates a new "SELECT ... FROM $tableRef" statement
 *
 * @param ITableRef $tableRef
 * @return SelectStmt
 */
function fromTable(ITableRef $tableRef) {
    return (new SelectStmt())->from($tableRef);
}