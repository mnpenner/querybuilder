<?php namespace QueryBuilder;

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
}