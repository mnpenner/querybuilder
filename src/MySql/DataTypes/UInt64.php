<?php namespace QueryBuilder\MySql\DataTypes;

class UInt64 extends Int64 {
    const MIN_VALUE = '0';
    const MAX_VALUE = '18446744073709551615';

    public function __construct($length=null, $zerofill=false) {
        parent::__construct($length, true, $zerofill);
    }
}