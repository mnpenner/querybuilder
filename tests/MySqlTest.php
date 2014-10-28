<?php
use QueryBuilder\ColumnSpec;
use QueryBuilder\MySql;
use QueryBuilder\TableAlias;
use QueryBuilder\TableSpec;
use QueryBuilder\Wild;

class MySqlTest extends PHPUnit_Framework_TestCase {
    /** @var MySql */
    protected $sql;

    protected function setUp() {
        $this->sql = new \QueryBuilder\MySql();
    }

    function testId() {
        $this->assertSame('`select`',$this->sql->id('select'));
        $this->assertSame('`a``b`',$this->sql->id('a`b'));
        $this->assertSame('`c"d`',$this->sql->id('c"d'));
    }

    function testColumnSpec() {
        $this->assertSame('`column`',(new ColumnSpec('column'))->toSql($this->sql));
        $this->assertSame('`table`.`column`',(new ColumnSpec('table','column'))->toSql($this->sql));
        $this->assertSame('`schema`.`table`.`column`',(new ColumnSpec('schema','table','column'))->toSql($this->sql));
        $this->assertSame('`sch``ema`.`tab.le`.`col"umn`',(new ColumnSpec('sch`ema','tab.le','col"umn'))->toSql($this->sql));
    }

    function testWild() {
        $this->assertInstanceOf(Wild::class, Wild::value());
        $this->assertSame(Wild::value(), Wild::value());
    }

    function testSelect() {
        $select = (new \QueryBuilder\SelectStmt())
            ->select(Wild::value())
            ->from(new TableAlias(new TableSpec('webenginex','clients'),'client'));
        $this->assertSame("SELECT * FROM `webenginex`.`clients` AS `client`",$select->toSql($this->sql));
    }
}
