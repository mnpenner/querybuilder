<?php namespace QueryBuilder;

class TableFactor implements ISql, ISchema {
    protected $tableName;
    protected $partitionNames;
    protected $indexHints;
}