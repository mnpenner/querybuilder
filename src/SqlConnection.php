<?php
namespace QueryBuilder;

abstract class SqlConnection {

    /**
     * Escapes an identifier.
     *
     * @param string $value
     * @return string
     */
    abstract public function id($value);

    public function fqn(...$ids) {
        return implode('.', array_map([$this, 'id'], $ids));
    }
}