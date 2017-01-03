<?php namespace QueryBuilder\Interfaces;

interface ITableRef {
    /**
     * Gets the table alias if present, otherwise table name.
     * 
     * @param ISqlConnection $conn
     * @param array $ctx
     * @return string
     */
    function getTableRef(ISqlConnection $conn, array &$ctx);
}