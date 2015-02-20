<?php namespace QueryBuilder;

class TableFactor implements ISql, ITableRef {
    protected $tableName;
    protected $partitionNames;
    protected $indexHints;
}