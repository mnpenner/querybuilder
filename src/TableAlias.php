<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\Interfaces\ITableAlias;

class TableAlias implements ITableAlias {
    use AliasTrait;

    /**
     * @param string $columnName
     * @return Column
     */
    public function column($columnName) {
        return new Column($columnName, $this);
    }
    
    function getTableRef(ISqlConnection $conn, array &$ctx) {
        return $conn->id($this->alias, $ctx);
    }
}