<?php namespace QueryBuilder\MySql\DataTypes;

class Int64 extends AbstractInt {
    const MIN_VALUE = '-9223372036854775808';
    const MAX_VALUE = '9223372036854775807';

    protected function getName() {
        return 'BIGINT';
    }
}