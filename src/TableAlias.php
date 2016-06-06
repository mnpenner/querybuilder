<?php namespace QueryBuilder;

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