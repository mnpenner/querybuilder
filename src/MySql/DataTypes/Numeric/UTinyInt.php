<?php namespace QueryBuilder\MySql\DataTypes\Numeric;

class UTinyInt extends TinyInt {
    const MIN_VALUE = '0';
    const MAX_VALUE = '255';

    public function __construct($length=null, $zerofill=false) {
        parent::__construct($length, true, $zerofill);
    }
}