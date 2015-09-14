<?php namespace QueryBuilder\MySql\DataTypes\Numeric;

class Int extends AbstractInt {
    const MIN_VALUE = '-2147483648';
    const MAX_VALUE = '2147483647';

    protected function getName() {
        return 'INT';
    }
}