<?php namespace QueryBuilder\MySql\DataTypes;

class Int8 extends AbstractInt {
    const MIN_VALUE = '-128';
    const MAX_VALUE = '127';

    protected function getName() {
        return 'TINYINT';
    }
}