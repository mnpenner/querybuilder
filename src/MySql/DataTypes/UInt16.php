<?php namespace QueryBuilder\MySql\DataTypes;

class UInt16 extends Int16 {
    const MIN_VALUE = '0';
    const MAX_VALUE = '65535';

    public function __construct($length=null, $zerofill=false) {
        parent::__construct($length, true, $zerofill);
    }
}