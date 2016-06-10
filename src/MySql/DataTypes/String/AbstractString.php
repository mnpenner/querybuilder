<?php namespace QueryBuilder\MySql\DataTypes\String;

use QueryBuilder\Interfaces\ICharset;
use QueryBuilder\Interfaces\ICollation;
use QueryBuilder\Interfaces\IDataType;
use QueryBuilder\Interfaces\ISqlConnection;

abstract class AbstractString implements IDataType {

    private $_length;
    private $_binary;
    private $_charSet;
    private $_collation;

    public function __construct($length=null, $binary=false, ICharset $charset=null, ICollation $collation=null) {
        $this->_length = $length;
        $this->_binary = $binary;
        $this->_charSet = $charset;
        $this->_collation = $collation;
    }

    abstract protected function getName();

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        $sql = self::getName();

        if($this->_length) {
            $sql .= '('.$this->_length.')';
        }

        if($this->_binary) {
            $sql .= ' BINARY';
        }

        if($this->_charSet) {
            $sql .= ' CHARACTER SET '.$this->_charSet->_toSql($conn, $ctx);
        }

        if($this->_collation) {
            $sql .= ' COLLATE '.$this->_collation->_toSql($conn, $ctx);
        }

        return $sql;
    }
}