<?php namespace QueryBuilder\MySql\DataTypes;

class UInt8 extends Int8 {
    const MIN_VALUE = '0';
    const MAX_VALUE = '255';

    public function __construct($length=null, $zerofill=false) {
        parent::__construct($length, true, $zerofill);
    }
}