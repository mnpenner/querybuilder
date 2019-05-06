<?php namespace QueryBuilder\MySql\DataTypes;

class UInt24 extends Int24 {
    const MIN_VALUE = '0';
    const MAX_VALUE = '16777215';

    public function __construct($length=null, $zerofill=false) {
        parent::__construct($length, true, $zerofill);
    }
}