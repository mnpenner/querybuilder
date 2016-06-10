<?php namespace QueryBuilder\Interfaces;

use QueryBuilder\Interfaces\IDict;

interface ISqlConnection {

    /**
     * Escapes an identifier.
     *
     * @param string $name
     * @param IDict $ctx
     * @return string
     */
    public function id($name, IDict $ctx);

    /**
     * Prepares a value for use in an SQL query string.
     *
     * @param mixed $value
     * @param IDict $ctx
     * @return string
     */
    public function quote($value, IDict $ctx);

    //public function bind($paramName, &$variable, $dataType, $length = null);

    /**
     * @param ISqlFrag $sql
     * @param \QueryBuilder\Interfaces\IDict $ctx
     * @return string
     */
    public function render(ISqlFrag $sql, IDict $ctx=null);
}