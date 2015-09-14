<?php namespace QueryBuilder\MySql\DataTypes\String;

class VarChar extends AbstractString {

    protected function getName() {
        return 'VARCHAR';
    }
}