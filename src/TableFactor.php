<?php namespace QueryBuilder;

class TableFactor implements ISql, ITable {
    protected $tableName;
    protected $partitionNames;
    protected $indexHints;
}