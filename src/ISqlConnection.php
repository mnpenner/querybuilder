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
     * Get the format for database stored dates.
     *
     * @return string
     */
    public function getDateFormat();


    //public function bind($paramName, &$variable, $dataType, $length = null);
    /**
     * @param mixed $value
     * @return string
     */
    public function quote($value);
}