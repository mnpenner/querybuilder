<?php namespace QueryBuilder\MySql\DataTypes;

class Char extends AbstractString {

    protected function getName() {
        return 'CHAR';
    }
}