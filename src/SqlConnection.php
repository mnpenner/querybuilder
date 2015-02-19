<?php namespace QueryBuilder;

interface SqlConnection {

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
}