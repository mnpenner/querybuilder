<?php namespace QueryBuilder\MySql\DataTypes\Numeric;

class UMediumInt extends MediumInt {
    const MIN_VALUE = '0';
    const MAX_VALUE = '16777215';

    public function __construct($length=null, $zerofill=false) {
        parent::__construct($length, true, $zerofill);
    }
}