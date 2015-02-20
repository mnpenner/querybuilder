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
    protected $mySql;

    protected function setUp() {
        $this->mySql = new \QueryBuilder\MySql();
    }

    function testId() {
        $this->assertSame('`select`',$this->mySql->id('select'));
        $this->assertSame('`a``b`',$this->mySql->id('a`b'));
        $this->assertSame('`c"d`',$this->mySql->id('c"d'));
    }

    function testColumnSpec() {
        $this->assertSame('`column`',(new ColumnSpec('column'))->toSql($this->mySql));
        $this->assertSame('`table`.`column`',(new ColumnSpec('table','column'))->toSql($this->mySql));
        $this->assertSame('`schema`.`table`.`column`',(new ColumnSpec('schema','table','column'))->toSql($this->mySql));
        $this->assertSame('`sch``ema`.`tab.le`.`col"umn`',(new ColumnSpec('sch`ema','tab.le','col"umn'))->toSql($this->mySql));
    }

    function testAllColumns() {
        $this->assertSame(Q\allColumns(), Q\allColumns(), "Repeated calls to Q\\allColumns() should return the same instance");
    }

    function testSelect() {
        $select = (new SelectStmt())
            ->select(Q\allColumns())
            ->from(new TableSpec('wx_user'));
        $this->assertSame("SELECT * FROM `wx_user`",$select->toSql($this->mySql));

        $select = (new SelectStmt())
            ->select(new ColumnSpec('wx_eafk_dso','client','ecl_name'), new ColumnAlias(new ColumnSpec('client','ecl_birth_date'),'dob'))
            ->from(new TableAlias(new TableSpec('wx_eafk_dso','emr_client'),'client'));
        $this->assertSame("SELECT `wx_eafk_dso`.`client`.`ecl_name`, `client`.`ecl_birth_date` AS `dob` FROM `wx_eafk_dso`.`emr_client` AS `client`",$select->toSql($this->mySql));

        $select = (new SelectStmt())
            ->select(Q\allColumns())
            ->from(Q\dual());
        $this->assertSame("SELECT * FROM DUAL",$select->toSql($this->mySql));

        $select = Q\selectAll(new TableSpec('emr_client'))->highPriority()->calcFoundRows()->distinct()->maxStatementTime(5)->straightJoin()->bufferResult()->noCache();
        $this->assertSame("SELECT DISTINCT HIGH_PRIORITY MAX_STATEMENT_TIME = 5 STRAIGHT_JOIN SQL_BUFFER_RESULT SQL_NO_CACHE SQL_CALC_FOUND_ROWS * FROM `emr_client`",$select->toSql($this->mySql));

        // todo: reproduce this: SELECT EXISTS(SELECT * FROM DUAL WHERE 0)
    }
}
