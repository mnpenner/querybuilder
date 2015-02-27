<?php namespace QueryBuilder;

trait OrderLimitTrait {
    /** @var null|int */
    protected $limit;
    /** @var null|int */
    protected $offset;

    /**
     * @param int|null $limit
     * @return $this
     */
    public function limit($limit) {
        $this->limit = $limit !== null ? (int)$limit : null;
        return $this;
    }

    /**
     * @param int|null $offset
     * @return $this
     */
    public function offset($offset) {
        $this->offset = $offset !== null ? (int)$offset : null;
        return $this;
    }

    protected function getOrderLimitSql() {
        $sb = [];
        if($this->limit !== null || $this->offset !== null) {
            $sb[] = 'LIMIT';
            $sb[] = $this->limit === null ? '18446744073709551615' : $this->limit;
            if($this->offset !== null) {
                $sb[] = 'OFFSET';
                $sb[] = $this->offset;
            }
        }
        return implode(' ',$sb);
    }

}