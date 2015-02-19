<?php
use QueryBuilder\ColumnAlias;
use QueryBuilder\ColumnSpec;
use QueryBuilder\MySql;
use QueryBuilder\SelectStmt;
use QueryBuilder\TableAlias;
use QueryBuilder\TableSpec;
use QueryBuilder as Q;

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
        $this->assertSame(Q\wild(), Q\wild(), "Repeated calls to Q\\wild() should return the same instance");
    }

    function testSelect() {
        $select = (new SelectStmt())
            ->select(Q\wild())
            ->from(new TableSpec('wx_user'));
        $this->assertSame("SELECT * FROM `wx_user`",$select->toSql($this->sql));

        $select = (new SelectStmt())
            ->select(new ColumnSpec('wx_eafk_dso','client','ecl_name'), new ColumnAlias(new ColumnSpec('client','ecl_birth_date'),'dob'))
            ->from(new TableAlias(new TableSpec('wx_eafk_dso','emr_client'),'client'));
        $this->assertSame("SELECT `wx_eafk_dso`.`client`.`ecl_name`, `client`.`ecl_birth_date` AS `dob` FROM `wx_eafk_dso`.`emr_client` AS `client`",$select->toSql($this->sql));

        $select = (new SelectStmt())
            ->select(Q\wild())
            ->from(Q\dual());
        $this->assertSame("SELECT * FROM DUAL",$select->toSql($this->sql));

        // todo: reproduce this: SELECT EXISTS(SELECT * FROM DUAL WHERE 0)
    }
}
