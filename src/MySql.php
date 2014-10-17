<?php
namespace QueryBuilder;

class MySql implements SqlConnection {


    /**
     * @param string $value
     * @return string
     */
    public function id($value) {
        return '`' . str_replace('`', '``', $value) . '`';
    }
}