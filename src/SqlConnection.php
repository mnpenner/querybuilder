<?php
namespace QueryBuilder;

interface SqlConnection {

    /**
     * Escapes an identifier.
     *
     * @param string $value
     * @return string
     */
    public function id($value);
}