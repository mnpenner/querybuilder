<?php namespace QueryBuilder;

interface ISqlConnection {

    /**
     * Escapes an identifier.
     *
     * @param string $value
     * @return string
     */
    public function id($value);

    /**
     * @param mixed $value
     * @return string
     */
    public function quote($value);

    //public function bind($paramName, &$variable, $dataType, $length = null);
}