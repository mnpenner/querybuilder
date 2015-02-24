<?php
use QueryBuilder\Asterisk;
use QueryBuilder\ColumnAlias;
use QueryBuilder\ColumnRef;
use QueryBuilder\Dual;
use QueryBuilder\AMySqlConnection;
use QueryBuilder\Node;
use QueryBuilder\Param;
use QueryBuilder\RawExpr;
use QueryBuilder\SelectStmt;
use QueryBuilder\SubQuery;
use QueryBuilder\TableAlias;
use QueryBuilder\TableRef;
use QueryBuilder\Value;

class MySqlTest extends PHPUnit_Framework_TestCase {
    /** @var AMySqlConnection */
    protected $conn;

    protected function setUp() {
        $this->conn = new \QueryBuilder\FakeMySqlConnection();
    }

    function testId() {
        $this->assertSame('`select`',$this->conn->id('select'));
        $this->assertSame('`a``b`',$this->conn->id('a`b'));
        $this->assertSame('`c"d`',$this->conn->id('c"d'));
    }

    function testColumnRef() {
        $this->assertSame('`column`',(new ColumnRef('column'))->toSql($this->conn));
        $this->assertSame('`table`.`column`',(new ColumnRef('table','column'))->toSql($this->conn));
        $this->assertSame('`schema`.`table`.`column`',(new ColumnRef('schema','table','column'))->toSql($this->conn));
        $this->assertSame('`sch``ema`.`tab.le`.`col"umn`',(new ColumnRef('sch`ema','tab.le','col"umn'))->toSql($this->conn));
    }

    function testSpecialValues() {
        $this->assertSame(Asterisk::value(), Asterisk::value(), "Repeated calls to Asterisk::value() should return the same instance");
        $this->assertSame(Dual::value(), Dual::value(), "Repeated calls to Dual::value() should return the same instance");
    }

    function testParam() {
        $select = (new SelectStmt())
            ->select(new Param, new Param('name'), new Param(null,3), new Param('count',3))
            ->from(new TableRef('table'));

        $this->assertSame("SELECT ?, :name, ?, ?, ?, :count0, :count1, :count2 FROM `table`",$this->conn->render($select));
    }

    function testParamException() {
        $this->setExpectedException('\Exception');
        new Param(null,-1);
    }

    function testValue() {
        $select = (new SelectStmt())->select(new Value(null), new Value(1), new Value(3.14), new Value(new \DateTime('1999-12-31 23:59:59')));
        $this->assertSame("SELECT NULL, 1, 3.14, '1999-12-31 23:59:59'",$this->conn->render($select));
    }

    function testFakeMySqlConnectionInjection() {
        $select = (new SelectStmt())->select(new Value("\xbf\x27 OR 1=1 /*"));
        $conn = new \QueryBuilder\FakeMySqlConnection(false,'iso-8859-1');
        // 0x5c = \
        // 0x27 = '

        // if the server charset is actually `gbk` then 0xbf5c will be interpreted as a single character,
        // and this query will actually look something like: SELECT * FROM test WHERE name = '縗' OR 1=1 /*' LIMIT 1
        // which of course a successful SQL injection attack; see http://stackoverflow.com/a/12118602/65387
        $this->assertSame("SELECT '\xbf\x5c\x27 OR 1=1 /*'",$conn->render($select),"SQL injection");

        // big5, cp932, gb2312, gbk and sjis

        foreach(['big5', 'gb2312', 'gbk', 'sjis', 'cp932'] as $charset) {
            $conn = new \QueryBuilder\FakeMySqlConnection(false, $charset);
            $this->assertSame("SELECT '\xbf\x27 OR 1=1 /*'", $conn->render($select), "SQL injection averted for $charset");
        }
    }

    function testFakeMySqlConnection() {
        $select = (new SelectStmt())->select(new Value("\"hello\"\r\n'world'"));
        $conn = new \QueryBuilder\FakeMySqlConnection(true,'utf8');
        $this->assertSame("SELECT '\"hello\"\r\n''world'''",$conn->render($select));
    }

    function testSelect() {
        $select = (new SelectStmt())
            ->select(Asterisk::value())
            ->from(new TableRef('wx_user'));
        $this->assertSame("SELECT * FROM `wx_user`",$select->toSql($this->conn));

        $select = (new SelectStmt())
            ->select(new ColumnRef('wx_eafk_dso','client','ecl_name'), new ColumnAlias(new ColumnRef('client','ecl_birth_date'),'dob'))
            ->from(new TableAlias(new TableRef('wx_eafk_dso','emr_client'),'client'));
        $this->assertSame("SELECT `wx_eafk_dso`.`client`.`ecl_name`, `client`.`ecl_birth_date` AS `dob` FROM `wx_eafk_dso`.`emr_client` AS `client`",$select->toSql($this->conn));

        $select = (new SelectStmt())
            ->select(Asterisk::value())
            ->from(Dual::value());
        $this->assertSame("SELECT * FROM DUAL",$select->toSql($this->conn));

        $select = (new SelectStmt())->select(Asterisk::value())->from(new TableRef('emr_client'))->highPriority()->calcFoundRows()->distinct()->maxStatementTime(5)->straightJoin()->bufferResult()->noCache();
        $this->assertSame("SELECT DISTINCT HIGH_PRIORITY MAX_STATEMENT_TIME = 5 STRAIGHT_JOIN SQL_BUFFER_RESULT SQL_NO_CACHE SQL_CALC_FOUND_ROWS * FROM `emr_client`",$select->toSql($this->conn));

        $select = (new SelectStmt())
            ->select((new SubQuery('EXISTS'))
                ->select(Asterisk::value())
                ->from(Dual::value())
                ->where(new RawExpr('0'))
            );
        $this->assertSame("SELECT EXISTS(SELECT * FROM DUAL WHERE 0)",$select->toSql($this->conn));


        $select = (new SelectStmt())
            ->select(new Node('AND',new RawExpr('0'),new RawExpr('1'),new RawExpr('2'),new Node('AND',new RawExpr('3'),new RawExpr('4'),new Node('OR',new RawExpr('5'),new RawExpr('6'),new Node('||')))));
        $this->assertSame("SELECT 0 AND 1 AND 2 AND 3 AND 4 AND (5 OR 6)",$select->toSql($this->conn));

        //$select = (new SelectStmt())->select(new Value(null), new Value(1), new Value(3.14), new Value(new \DateTime('1999-12-31 23:59:59')));
        //$this->assertSame("SELECT NULL, 1, 3.14, '1999-12-31 23:59:59'",$this->conn->render($select));

        //$select = (new SelectStmt())->from(new TableRef('table'))->select(Asterisk::value())->where(new Param('bacon'));
        //var_dump($select->toSql($this->mySql));
        //exit;

        //var_dump($select->toSql($this->mySql));
        // todo: reproduce this: SELECT EXISTS(SELECT * FROM DUAL WHERE 0)
        // (new SelectStmt())->select(new SubQuery('exists')->
    }
}
