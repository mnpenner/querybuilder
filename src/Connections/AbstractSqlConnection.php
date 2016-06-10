<?php namespace QueryBuilder\Connections;

use QueryBuilder\Dict;
use QueryBuilder\Interfaces\IDict;
use QueryBuilder\Interfaces\ISqlFrag;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\IStatement;
use QueryBuilder\Util;

abstract class AbstractSqlConnection implements ISqlConnection {
    /**
     * @param ISqlFrag $sql
     * @param IDict $ctx
     * @return string
     */
    public function render(ISqlFrag $sql, IDict $ctx=null){
        if(!$ctx) $ctx = new Dict;
        return $sql->_toSql($this, $ctx);
    }

    /**
     * @param \DateTime $date
     * @return string
     */
    public function formatDate(\DateTime $date) {
        return $date->format($this->getDateFormat());
    }

    public function quote($value, IDict $ctx) {
        if(is_string($value)) return $this->quoteString($value,$ctx);
        elseif(is_null($value)) return 'NULL';
        elseif(is_int($value) || is_float($value)) return (string)$value;
        elseif(is_bool($value)) return $value ? '1' : '0';
        elseif($value instanceof ISqlFrag) return $value->_toSql($this,$ctx);
        elseif($value instanceof \DateTime) return $this->quoteString($this->formatDate($value),$ctx);
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
     * @param IDict $ctx
     * @return string
     */
    abstract protected function quoteString($string, IDict $ctx);

    /**
     * Get the format for database stored dates.
     *
     * @return string
     */
    abstract public function getDateFormat();
}