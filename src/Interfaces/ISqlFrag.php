<?php namespace QueryBuilder\Interfaces;

/**
 * May be transformed into an SQL string
 */
interface ISqlFrag {

    /**
     * Consumers should never call this function directly; use `ISqlConnection::render`
     *
     * @param ISqlConnection $conn An active SQL database connection
     * @param array &$ctx Context, passed throughout rendering
     * @return string An SQL string
     * @see \QueryBuilder\Interfaces\ISqlConnection::render
     * @internal
     */
    public function _toSql(ISqlConnection $conn, array &$ctx);
}