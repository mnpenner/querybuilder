<?php namespace QueryBuilder;
use QueryBuilder\Operator\Equal;
use QueryBuilder\Statements\Select;

/**
 * DUAL is purely for the convenience of people who require that all SELECT statements should have FROM and possibly other clauses. MySQL may ignore the clauses. MySQL does not require FROM DUAL if no tables are referenced.
 *
 * @return ITable
 */
//function dual() {
//    return Dual::value();
//}

/**
 * A select list consisting only of a single unqualified * can be used as shorthand to select all columns from all tables.
 *
 * Use of an unqualified * with other items in the select list may produce a parse error. To avoid this problem, use a qualified tbl_name.* reference.
 *
 * @return IExpr
 */
//function allColumns() {
//    return Asterisk::value();
//}

/**
 * Creates a new "SELECT * FROM $tableRef" statement.
 *
 * @param ITable $tableRef
 * @return Select
 */
//function selectAll(ITable $tableRef=null) {
//    return (new Select())->select(Asterisk::value())->from($tableRef);
//}

/**
 * Creates a new "SELECT ... FROM $tableRef" statement
 *
 * @param ITable $tableRef
 * @return Select
 */
//function fromTable(ITable $tableRef) {
//    return (new Select())->from($tableRef);
//}

/**
 * Returns a new EXISTS(SELECT ...) subquery.
 *
 * @return SubQuery
 */
//function exists() {
//    return new SubQuery('EXISTS');
//}


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

/**
 * @param string $val
 * @return IValue
 */
function val($val) {
    return new Value($val);
}

/**
 * @param string[] ...$vals
 * @return IValue[]
 */
function values(...$vals) {
    return array_map(function($v) { return val($v); }, $vals);
}


/**
 * @param string $val
 * @return IColumn
 */
function col($val) {
    return new Column($val);
}

/**
 * @param string[] $cols
 * @return IColumn[]
 */
function columns(...$cols) {
    return array_map(function($v) { return col($v); }, $cols);
}


/**
 * @param IExpr $expr
 * @param string $alias
 * @return IField
 */
function exprAs(IExpr $expr, $alias) {
    return new ExprAs($expr,falias($alias));
}


/**
 * @param ISelect $select
 * @param string $alias
 * @return IField
 */
function selectAs(ISelect $select, $alias) {
    return exprAs(new SelectExpr($select),$alias);
}


/**
 * @param string $columnName
 * @param string $alias
 * @return IField
 */
function colAs($columnName, $alias) {
    return exprAs(col($columnName),$alias);
}

function eq(IExpr $a, IExpr $b) {
    return new Equal($a,$b);
}

/**
 * @param string $col1
 * @param string $col2
 * @return Equal
 */
function eqCols($col1, $col2) {
    return eq(col($col1),col($col2));
}

/**
 * @param string $column
 * @param mixed $value
 * @return Equal
 */
function eqColVal($column, $value) {
    return eq(col($column),val($value));
}

/**
 * @param string $alias
 * @return ITableAlias
 */
function talias($alias) {
    return new TableAlias($alias);
}

/**
 * @param string $alias
 * @return IFieldAlias
 */
function falias($alias) {
    return new FieldAlias($alias);
}

/**
 * @param string $tableName
 * @param null|string $databaseName
 * @return ITable
 */
function tbl($tableName, $databaseName=null) {
    return new Table($tableName, $databaseName ? new Database($databaseName) : null);
}

/**
 * TODO: MOVE THIS TO AN ENTIRELY DIFFERENT REPO/PROJECT THAT DEPENDS ON QUERY BUILDER
 * THIS WAY WE CAN REPLACE THE "NICE" API LATER
 */