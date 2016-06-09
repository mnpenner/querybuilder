<?php namespace QueryBuilder;

use ArrayAccess;
use QueryBuilder\Interfaces\IDict;

class Dict implements IDict {
    private $_data = [];

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset) {
        return array_key_exists(self::hash($offset), $this->_data);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset) {
        return $this->_data[self::hash($offset)];
    }

    /**
     * @param mixed $var
     * @return string
     */
    private static function hash($var) {
        return is_object($var) ? spl_object_hash($var) : json_encode($var,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value) {
        $this->_data[self::hash($offset)] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset) {
        unset($this->_data[self::hash($offset)]);
    }
}