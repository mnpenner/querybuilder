<?php namespace QueryBuilder\MySql\DataTypes\Numeric;

use QueryBuilder\IDataType;
use QueryBuilder\ISqlConnection;

abstract class AbstractInt implements IDataType {

    private $_length;
    private $_zerofill;
    private $_unsigned;

    public function __construct($length=null, $unsigned=null, $zerofill=false) {
        $this->_length = $length;
        $this->_unsigned = $unsigned;
        $this->_zerofill = $zerofill;
    }

    abstract protected function getName();

    public function toSql(ISqlConnection $conn) {
        $sql = self::getName();

        if($this->_length !== null) {
            $sql .= '('.$this->_length.')'; // should length be escaped?
        }

        if($this->_unsigned) {
            $sql .= ' UNSIGNED';
        }

        if($this->_zerofill) {
            $sql .= ' ZEROFILL';
        }

        return $sql;
    }
}