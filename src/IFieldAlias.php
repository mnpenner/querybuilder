<?php namespace QueryBuilder;

/**
 * An alias can be used in a query select list to give a column a different name. You can use the alias in GROUP BY, ORDER BY, or HAVING clauses to refer to the column.
 *
 * Standard SQL disallows references to column aliases in a WHERE clause. This restriction is imposed because when the WHERE clause is evaluated, the column value may not yet have been determined.
 */
interface IFieldAlias extends IAliasOrColumn {
}