<?php namespace QueryBuilder\Interfaces;

interface ISqlConnection {

    /**
     * Escapes an identifier.
     *
     * @param string $name
     * @return string
     */
    public function id($name);

    /**
     * Prepares a value for use in an SQL query string.
     *
     * @param mixed $value
     * @return string
     */
    public function quote($value);

    //public function bind($paramName, &$variable, $dataType, $length = null);
}