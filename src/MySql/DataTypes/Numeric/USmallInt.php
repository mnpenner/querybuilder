<?php namespace QueryBuilder\MySql\DataTypes\Numeric;

class USmallInt extends SmallInt {
    const MIN_VALUE = '0';
    const MAX_VALUE = '65535';

    public function __construct($length=null, $zerofill=false) {
        parent::__construct($length, true, $zerofill);
    }
}