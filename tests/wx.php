<?php
namespace wxtest1;

use QueryBuilder\Functions\Stmt;
use QueryBuilder\Value;

class DbSchema {
    public function __construct($database_name) {
    }

    public function table($table_name) {
        return new Table($this, $table_name);
    }
}

class Table {
    public function __construct(DbSchema $schema, $table_name) {
    }

    public function alias($alias) {
        return new TableAlias($this, $alias);
    }
}

class TableAlias {
    public function __construct(Table $table, $alias = null) {
    }
}

$wx = new DbSchema('webenginex');

$userTbl = $wx->table('wx_user');

Stmt::select()->from($f1 = $userTbl->alias('friend1'))->innerJoin($f2 = $userTbl->alias('friend2'), new Value(1))
    ->select($f1->column('name'), $f2->column('name'));