<?php namespace QueryBuilder\MySql\DataTypes\Numeric;

class UInt extends Int {
    const MIN_VALUE = '0';
    const MAX_VALUE = '4294967295';

    public function __construct($length=null, $zerofill=false) {
        parent::__construct($length, true, $zerofill);
    }
}