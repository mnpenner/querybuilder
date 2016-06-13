<?php namespace QueryBuilder\Connections;

use QueryBuilder\Interfaces\ISqlFrag;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\IStatement;
use QueryBuilder\Util;

abstract class AbstractSqlConnection implements ISqlConnection {

    public function render(ISqlFrag $sql, array &$ctx=[]){
        return $sql->_toSql($this, $ctx);
    }

    /**
     * @param \DateTimeInterface $date
     * @return string
     */
    public function formatDateTime(\DateTimeInterface $date) {
        return $date->format($this->getDateTimeFormat());
    }

    public function quote($value, array &$ctx) {
        if(is_string($value)) return $this->quoteString($value,$ctx);
        elseif(is_null($value)) return 'NULL';
        elseif(is_int($value) || is_float($value)) return (string)$value;
        elseif(is_bool($value)) return $value ? '1' : '0';
        elseif($value instanceof ISqlFrag) return $value->_toSql($this,$ctx);
        elseif($value instanceof \DateTimeInterface) return $this->quoteString($this->formatDateTime($value),$ctx);
        elseif(is_array($value)) {
            if(Util::isAssoc($value)) {
                $pairs = [];
                foreach($value as $k => $v) {
                    $pairs[] = $this->id($k, $ctx) . '=' . $this->quote($v, $ctx);
                }
                return implode(', ', $pairs);
            }
            return '(' . implode(', ', array_map(__METHOD__, $value)) . ')'; // FIXME: are we sure we want the parens here?
        }
        elseif($value instanceof \Traversable) return $this->quote(iterator_to_array($value->getIterator()), $ctx);
        throw new \Exception("Cannot quote value of type ".Util::getType($value));
    }

    /**
     * Quotes a string for use in a query.
     *
     * @param string $string The string to be quoted.
     * @param array &$ctx
     * @return string
     */
    abstract protected function quoteString($string, array &$ctx);

    /**
     * Get the format for database stored dates.
     *
     * @return string
     */
    abstract public function getDateTimeFormat();
}