<?php namespace QueryBuilder\MySql\DataTypes;

class VarChar extends AbstractString {

    protected function getName() {
        return 'VARCHAR';
    }
}