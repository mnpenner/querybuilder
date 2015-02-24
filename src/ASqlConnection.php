<?php namespace QueryBuilder;

abstract class ASqlConnection implements ISqlConnection {
    /**
     * @param ISql $sql
     * @return string
     */
    public function render(ISql $sql){
        return $sql->toSql($this);
    }

    /**
     * @param \DateTime $date
     * @return string
     */
    public function formatDate(\DateTime $date) {
        return $date->format($this->getDateFormat());
    }

    public function quote($value) {
        if(is_null($value)) return 'NULL';
        elseif(is_bool($value)) return $value ? '1' : '0';
        elseif($value instanceof ISql) return $this->render($value);
        elseif(is_int($value) || is_float($value)) return (string)$value;
        elseif($value instanceof \DateTime) return $this->quoteString($this->formatDate($value));
        elseif(is_array($value)) {
            if(Util::isAssoc($value)) {
                $pairs = [];
                foreach($value as $k => $v) {
                    $pairs[] = $this->id($k) . '=' . $this->quote($v);
                }
                return implode(', ', $pairs);
            }
            return '(' . implode(', ', array_map(__METHOD__, $value)) . ')';
        } elseif(is_string($value)) {
            return $this->quoteString($value);
        }
        throw new \Exception("Cannot quote value of type ".Util::getType($value));
    }

    /**
     * @param string $string
     * @return string
     */
    abstract protected function quoteString($string);

    /**
     * Get the format for database stored dates.
     *
     * @return string
     */
    abstract public function getDateFormat();
}