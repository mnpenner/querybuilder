<?php
use QueryBuilder\Asterisk;
use QueryBuilder\ColumnAlias;
use QueryBuilder\ColumnRef;
use QueryBuilder\Dual;
use QueryBuilder\MySql;
use QueryBuilder\Node;
use QueryBuilder\RawExpr;
use QueryBuilder\SelectStmt;
use QueryBuilder\SubQuery;
use QueryBuilder\TableAlias;
use QueryBuilder\TableRef;

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

    function testColumnRef() {
        $this->assertSame('`column`',(new ColumnRef('column'))->toSql($this->mySql));
        $this->assertSame('`table`.`column`',(new ColumnRef('table','column'))->toSql($this->mySql));
        $this->assertSame('`schema`.`table`.`column`',(new ColumnRef('schema','table','column'))->toSql($this->mySql));
        $this->assertSame('`sch``ema`.`tab.le`.`col"umn`',(new ColumnRef('sch`ema','tab.le','col"umn'))->toSql($this->mySql));
    }

    function testAllColumns() {
        $this->assertSame(Asterisk::value(), Asterisk::value(), "Repeated calls to Q\\allColumns() should return the same instance");
    }

    function testSelect() {
        $select = (new SelectStmt())
            ->select(Asterisk::value())
            ->from(new TableRef('wx_user'));
        $this->assertSame("SELECT * FROM `wx_user`",$select->toSql($this->mySql));

        $select = (new SelectStmt())
            ->select(new ColumnRef('wx_eafk_dso','client','ecl_name'), new ColumnAlias(new ColumnRef('client','ecl_birth_date'),'dob'))
            ->from(new TableAlias(new TableRef('wx_eafk_dso','emr_client'),'client'));
        $this->assertSame("SELECT `wx_eafk_dso`.`client`.`ecl_name`, `client`.`ecl_birth_date` AS `dob` FROM `wx_eafk_dso`.`emr_client` AS `client`",$select->toSql($this->mySql));

        $select = (new SelectStmt())
            ->select(Asterisk::value())
            ->from(Dual::value());
        $this->assertSame("SELECT * FROM DUAL",$select->toSql($this->mySql));

        $select = (new SelectStmt())->select(Asterisk::value())->from(new TableRef('emr_client'))->highPriority()->calcFoundRows()->distinct()->maxStatementTime(5)->straightJoin()->bufferResult()->noCache();
        $this->assertSame("SELECT DISTINCT HIGH_PRIORITY MAX_STATEMENT_TIME = 5 STRAIGHT_JOIN SQL_BUFFER_RESULT SQL_NO_CACHE SQL_CALC_FOUND_ROWS * FROM `emr_client`",$select->toSql($this->mySql));

        $select = (new SelectStmt())
            ->select((new SubQuery('EXISTS'))
                ->select(Asterisk::value())
                ->from(Dual::value())
                ->where(new RawExpr('0')));
        $this->assertSame("SELECT EXISTS(SELECT * FROM DUAL WHERE 0)",$select->toSql($this->mySql));


        $select = (new SelectStmt())
            ->select(new Node('AND',new RawExpr('0'),new RawExpr('1'),new RawExpr('2'),new Node('AND',new RawExpr('3'),new RawExpr('4'),new Node('OR',new RawExpr('5'),new RawExpr('6'),new Node('||')))));

        //var_dump($select->toSql($this->mySql));
        // todo: reproduce this: SELECT EXISTS(SELECT * FROM DUAL WHERE 0)
        // (new SelectStmt())->select(new SubQuery('exists')->
    }
}
