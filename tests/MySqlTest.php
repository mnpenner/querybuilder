<?php
use QueryBuilder\Asterisk;
use QueryBuilder\Column;
use QueryBuilder\ColumnAlias;
use QueryBuilder\Connections\AbstractMySqlConnection;
use QueryBuilder\Dual;
use QueryBuilder\Nodes\Node;
use QueryBuilder\Param;
use QueryBuilder\RawExpr;
use QueryBuilder\Statements\Select;
use QueryBuilder\SubQuery;
use QueryBuilder\SubQueryAlias;
use QueryBuilder\Table;
use QueryBuilder\TableAlias;
use QueryBuilder\Value;

class MySqlTest extends PHPUnit_Framework_TestCase {
    /** @var AbstractMySqlConnection */
    protected $conn;

    protected function setUp() {
        $this->conn = new \QueryBuilder\Connections\FakeMySqlConnection();
    }

    function testId() {
        $this->assertSame('`select`',$this->conn->id('select'));
        $this->assertSame('`a``b`',$this->conn->id('a`b'));
        $this->assertSame('`c"d`',$this->conn->id('c"d'));
    }

    function testColumnRef() {
        $this->assertSame('`column`',(new Column('column'))->toSql($this->conn));
        $this->assertSame('`table`.`column`',(new Column('table','column'))->toSql($this->conn));
        $this->assertSame('`schema`.`table`.`column`',(new Column('schema','table','column'))->toSql($this->conn));
        $this->assertSame('`sch``ema`.`tab.le`.`col"umn`',(new Column('sch`ema','tab.le','col"umn'))->toSql($this->conn));
    }

    function testSpecialValues() {
        $this->assertSame(Asterisk::value(), Asterisk::value(), "Repeated calls to Asterisk::value() should return the same instance");
        $this->assertSame(Dual::value(), Dual::value(), "Repeated calls to Dual::value() should return the same instance");
    }

    function testParam() {
        $select = (new Select())
            ->fields(new Param, new Param('name'), new Param(null,3), new Param('count',3))
            ->from(new Table('table'));

        $this->assertSame("SELECT ?, :name, ?, ?, ?, :count0, :count1, :count2 FROM `table`",$this->conn->render($select));
    }

    function testParamException() {
        $this->setExpectedException('\Exception');
        new Param(null,-1);
    }

    function testValue() {
        $select = (new Select())->fields(new Value(null), new Value(1), new Value(3.14), new Value(new \DateTime('1999-12-31 23:59:59')));
        $this->assertSame("SELECT NULL, 1, 3.14, '1999-12-31 23:59:59'",$this->conn->render($select));
    }

    function testFakeMySqlConnectionInjection() {
        $select = (new Select())->fields(new Value("\xbf\x27 OR 1=1 /*"));
        $conn = new \QueryBuilder\Connections\FakeMySqlConnection('iso-8859-1', false);
        // 0x5c = \
        // 0x27 = '

        // if the server charset is actually `gbk` then 0xbf5c will be interpreted as a single character,
        // and this query will actually look something like: SELECT * FROM test WHERE name = '縗' OR 1=1 /*' LIMIT 1
        // which of course a successful SQL injection attack; see http://stackoverflow.com/a/12118602/65387
        $this->assertSame("SELECT '\xbf\x5c\x27 OR 1=1 /*'",$conn->render($select),"SQL injection");

        // despite what that answer says, I don't think  'sjis' and 'cp932' are vulnerable.. see here: http://stackoverflow.com/q/28705324/65387

        foreach(['big5', 'gb2312', 'gbk'] as $charset) {
            $conn = new \QueryBuilder\Connections\FakeMySqlConnection($charset, false);
            $this->assertSame("SELECT '\xbf\x27 OR 1=1 /*'", $conn->render($select), "SQL injection averted for $charset");
        }
    }

    function testFakeMySqlConnectionNoBackslashEscapes() {
        $select = (new Select())->fields(new Value("\"hello\"\r\n'world'"));
        $conn = new \QueryBuilder\Connections\FakeMySqlConnection('utf8', true);
        $this->assertSame("SELECT '\"hello\"\r\n''world'''",$conn->render($select));
    }

    function testFrom() {
        $select = (new Select())
            ->from(new Table('t1'), new Table('t2'), new Table('t3'))
            ->fields(Asterisk::value())
        ;
        $this->assertSame("SELECT * FROM `t1`, `t2`, `t3`",$this->conn->render($select));
    }


    function testJoins() {
        $select = (new Select())
            ->from(new Table('t1'))
            ->fields(Asterisk::value())
        ;
        $this->assertSame("SELECT * FROM `t1` INNER JOIN `t2` ON 2 LEFT JOIN `t3` ON 3 RIGHT JOIN `t4` ON 4 STRAIGHT_JOIN `t5` ON 5 NATURAL JOIN `t6` NATURAL LEFT JOIN `t7` NATURAL RIGHT JOIN `t8`",$this->conn->render($select->copy()
            ->innerJoin(new Table('t2'),new Value(2))
            ->leftJoin(new Table('t3'),new Value(3))
            ->rightJoin(new Table('t4'),new Value(4))
            ->straightJoin(new Table('t5'),new Value(5))
            ->naturalJoin(new Table('t6'))
            ->naturalLeftJoin(new Table('t7'))
            ->naturalRightJoin(new Table('t8'))
        ));
    }

    function testKeywords() {
        $select = (new Select())->fields(Asterisk::value())->from(new Table('t1'))->highPriority()->calcFoundRows()->distinct()->maxStatementTime(5)->straightJoinTables()->bufferResult()->noCache();
        $this->assertSame("SELECT DISTINCT HIGH_PRIORITY MAX_STATEMENT_TIME = 5 STRAIGHT_JOIN SQL_BUFFER_RESULT SQL_NO_CACHE SQL_CALC_FOUND_ROWS * FROM `t1`",$select->toSql($this->conn));

        $select = (new Select())->fields(Asterisk::value())->from(new Table('t2'))->cache()->all();
        $this->assertSame("SELECT ALL SQL_CACHE * FROM `t2`",$select->toSql($this->conn));
    }

    function testJoinSubQuery() {
        $select = (new Select())
            ->from(new Table('t1'))
            ->fields(Asterisk::value())
            ->innerJoin(new SubQueryAlias(
                (new SubQuery())
                    ->from(new Table('t2'))
                    ->fields(Asterisk::value())
                ,'t2')
            );

        $this->assertSame("SELECT * FROM `t1` INNER JOIN (SELECT * FROM `t2`) AS `t2`",$select->toSql($this->conn));
    }

    function testSelect() {
        $select = (new Select())
            ->fields(Asterisk::value())
            ->from(new Table('wx_user'));
        $this->assertSame("SELECT * FROM `wx_user`",$select->toSql($this->conn));

        $select = (new Select())
            ->fields(new Column('wx_eafk_dso','client','ecl_name'), new ColumnAlias(new Column('client','ecl_birth_date'),'dob'))
            ->from(new TableAlias(new Table('wx_eafk_dso','emr_client'),'client'));
        $this->assertSame("SELECT `wx_eafk_dso`.`client`.`ecl_name`, `client`.`ecl_birth_date` AS `dob` FROM `wx_eafk_dso`.`emr_client` AS `client`",$select->toSql($this->conn));

        $select = (new Select())
            ->fields(Asterisk::value())
            ->from(Dual::value());
        $this->assertSame("SELECT * FROM DUAL",$select->toSql($this->conn));



        $select = (new Select())
            ->fields((new SubQuery('EXISTS'))
                ->fields(Asterisk::value())
                ->from(Dual::value())
                ->where(new RawExpr('0'))
            );
        $this->assertSame("SELECT EXISTS(SELECT * FROM DUAL WHERE 0)",$select->toSql($this->conn));


        $select = (new Select())
            ->fields(new Node('AND',new RawExpr('0'),new RawExpr('1'),new RawExpr('2'),new Node('AND',new RawExpr('3'),new RawExpr('4'),new Node('OR',new RawExpr('5'),new RawExpr('6'),new Node('||')))));
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
