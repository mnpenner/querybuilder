<?php namespace QueryBuilder\MySql\DataTypes\Numeric;

class MediumInt extends AbstractInt {
    const MIN_VALUE = '-8388608';
    const MAX_VALUE = '8388607';

    protected function getName() {
        return 'MEDIUMINT';
    }
}