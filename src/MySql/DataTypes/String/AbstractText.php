<?php namespace QueryBuilder\MySql\DataTypes\String;

use QueryBuilder\ICharset;
use QueryBuilder\ICollation;
use QueryBuilder\IDataType;
use QueryBuilder\ISqlConnection;

abstract class AbstractText implements IDataType {

    private $_binary;
    private $_charSet;
    private $_collation;

    public function __construct($binary=false, ICharset $charset=null, ICollation $collation=null) {
        $this->_binary = $binary;
        $this->_charSet = $charset;
        $this->_collation = $collation;
    }

    abstract protected function getName();

    public function toSql(ISqlConnection $conn) {
        $sql = self::getName();

        if($this->_binary) {
            $sql .= ' BINARY';
        }

        if($this->_charSet) {
            $sql .= ' CHARACTER SET '.$this->_charSet->toSql($conn);
        }

        if($this->_collation) {
            $sql .= ' COLLATE '.$this->_collation->toSql($conn);
        }

        return $sql;
    }
}