<?php namespace QueryBuilder\MySql\DataTypes\Numeric;

class SmallInt extends AbstractInt {
    const MIN_VALUE = '-32768';
    const MAX_VALUE = '32767';

    protected function getName() {
        return 'SMALLINT';
    }
}