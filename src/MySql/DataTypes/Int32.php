<?php namespace QueryBuilder\MySql\DataTypes;

class Int32 extends AbstractInt {
    const MIN_VALUE = '-2147483648';
    const MAX_VALUE = '2147483647';

    protected function getName() {
        return 'INT';
    }
}