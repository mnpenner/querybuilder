<?php namespace QueryBuilder\Interfaces;


interface ISqlConnection {

    /**
     * Escapes an identifier.
     *
     * @param string $name
     * @param array &$ctx
     * @return string
     */
    public function id($name, array &$ctx);

    /**
     * Prepares a value for use in an SQL query string.
     *
     * @param mixed $value
     * @param array &$ctx
     * @return string
     */
    public function quote($value, array &$ctx);

    //public function bind($paramName, &$variable, $dataType, $length = null);

    /**
     * @param ISqlFrag $sql
     * @param array &$ctx
     * @return string
     */
    public function render(ISqlFrag $sql, array &$ctx=[]);
}