<?php namespace QueryBuilder\MySql\DataTypes\Numeric;

use QueryBuilder\Interfaces\IDataType;
use QueryBuilder\Interfaces\ISqlConnection;

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

    public function _toSql(ISqlConnection $conn, \QueryBuilder\Interfaces\IDict $ctx) {
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