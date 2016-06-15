<?php namespace QueryBuilder\Collections;
use QueryBuilder\Util;

/**
 * Double-ended queue.
 * @internal Not recommended for outside use
 */
class Deque implements \Countable, \IteratorAggregate {
    /** @var array */
    private $_data;

    /**
     * @param array|null|\Traversable $init
     * @throws \Exception
     */
    public function __construct($init=null) {
        if($init instanceof \Traversable) {
            $this->_data = iterator_to_array($init,false);
        } elseif(is_array($init)) {
            $this->_data = array_values($init);
        } elseif($init === null) {
            $this->_data = [];
        } else {
            throw new \InvalidArgumentException(__METHOD__.' expects an iterable, got '.Util::getType($init));
        }
    }
    
    public function count() {
        return count($this->_data);
    }
    
    public function getIterator() {
        return new \ArrayIterator($this->_data);
    }
    
    public function append(...$elements) {
        array_push($this->_data, ...$elements);
    }

    public function prepend(...$elements) {
        array_unshift($this->_data, ...$elements);
    }

    public function pop() {
        return array_pop($this->_data);
    }

    public function shift() {
        return array_shift($this->_data);
    }

    public function clear() {
        $this->_data = [];
    }

    public function last() {
        return end($this->_data);
    }

    public function first() {
        return reset($this->_data);
    }

    public function toArray() {
        return $this->_data;
    }

    public function map($fn) {
        return array_map($fn, $this->_data);
    }

    public function reduce($fn, $initial=null) {
        return array_reduce($fn, $this->_data, $initial);
    }
}