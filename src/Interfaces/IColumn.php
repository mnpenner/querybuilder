<?php namespace QueryBuilder\Interfaces;
use QueryBuilder\Interfaces\IAliasOrColumn;

/**
 * May be used wherever IFields or IExprs are accepted, as well in INSERT and UPDATE statements
 *
 * e.g.  INSERT INTO t1 (<IColumn>), UPDATE t1 SET <IColumn>=expr
 */
interface IColumn extends IAliasOrColumn {
}