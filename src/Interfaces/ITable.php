<?php namespace QueryBuilder\Interfaces;
use QueryBuilder\Interfaces\ITableAs;

/**
 * May be used in a FROM/JOIN clause.
 */
interface ITable extends ITableOrTableAlias {
    /**
     * Gets the table name, without qualifiers (no dots).
     *
     * @return string
     */
    function getTableName();
}