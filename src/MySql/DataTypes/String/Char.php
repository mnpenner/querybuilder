<?php namespace QueryBuilder\MySql\DataTypes\String;

class Char extends AbstractString {

    protected function getName() {
        return 'CHAR';
    }
}