<?php namespace QueryBuilder\MySql\DataTypes\Numeric;

class BigInt extends AbstractInt {
    const MIN_VALUE = '-9223372036854775808';
    const MAX_VALUE = '9223372036854775807';

    protected function getName() {
        return 'BIGINT';
    }
}