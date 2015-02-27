<?php
use QueryBuilder\FieldAlias;
use QueryBuilder\Asterisk;
use QueryBuilder\Column;
use QueryBuilder\FieldAsAlias;
use QueryBuilder\Connections\AbstractMySqlConnection;
use QueryBuilder\Dual;
use QueryBuilder\Functions\Count;
use QueryBuilder\Functions\Exists;
use QueryBuilder\Functions\Sum;
use QueryBuilder\Nodes\AndNode;
use QueryBuilder\Nodes\ConcatNode;
use QueryBuilder\Nodes\Node;
use QueryBuilder\Nodes\OrNode;
use QueryBuilder\Param;
use QueryBuilder\RawExpr;
use QueryBuilder\Statements\Select;
use QueryBuilder\Statements\Union;
use QueryBuilder\Statements\UnionAll;
//use QueryBuilder\SubQuery;
use QueryBuilder\SubQueryTable;
use QueryBuilder\Table;
use QueryBuilder\TableAlias;
use QueryBuilder\TableAsAlias;
use QueryBuilder\Util;
use QueryBuilder\Value;

class MySqlTest extends TestCase {
    /** @var AbstractMySqlConnection */
    protected $conn;

    protected function setUp() {
        $this->conn = new \QueryBuilder\Connections\FakeMySqlConnection();
    }

    function testId() {
        $this->assertSimilar('`select`',$this->conn->id('select'));
        $this->assertSimilar('`a``b`',$this->conn->id('a`b'));
        $this->assertSimilar('`c"d`',$this->conn->id('c"d'));
    }

    function testColumnRef() {
        $this->assertSimilar('`column`',(new Column('column'))->toSql($this->conn));
        $this->assertSimilar('`table`.`column`',(new Column('table','column'))->toSql($this->conn));
        $this->assertSimilar('`schema`.`table`.`column`',(new Column('schema','table','column'))->toSql($this->conn));
        $this->assertSimilar('`sch``ema`.`tab.le`.`col"umn`',(new Column('sch`ema','tab.le','col"umn'))->toSql($this->conn));
    }

    //function testSpecialValues() {
    //    $this->assertSimilar(new Asterisk, new Asterisk, "Repeated calls to new Asterisk should return the same instance");
    //    $this->assertSimilar(Dual::value(), Dual::value(), "Repeated calls to Dual::value() should return the same instance");
    //}

    function testParam() {
        $select = (new Select())
            ->fields(new Param, new Param('name'), new Param(null,3), new Param('count',3))
            ->from(new Table('table'));

        $this->assertSimilar("SELECT ?, :name, ?, ?, ?, :count0, :count1, :count2 FROM `table`",$this->conn->render($select));
    }

    function testParamException() {
        $this->setExpectedException(Exception::class);
        new Param(null,-1);
    }

    function testValue() {
        $select = (new Select())->fields(new Value(null), new Value(1), new Value(3.14), new Value(new \DateTime('1999-12-31 23:59:59')));
        $this->assertSimilar("SELECT NULL, 1, 3.14, '1999-12-31 23:59:59'",$this->conn->render($select));
    }

    function testFakeMySqlConnectionInjection() {
        $select = (new Select())->fields(new Value("\xbf\x27 OR 1=1 /*"));
        $conn = new \QueryBuilder\Connections\FakeMySqlConnection('iso-8859-1', false);
        // 0x5c = \
        // 0x27 = '

        // if the server charset is actually `gbk` then 0xbf5c will be interpreted as a single character,
        // and this query will actually look something like: SELECT * FROM test WHERE name = '縗' OR 1=1 /*' LIMIT 1
        // which of course a successful SQL injection attack; see http://stackoverflow.com/a/12118602/65387
        $this->assertSimilar("SELECT '\xbf\x5c\x27 OR 1=1 /*'",$conn->render($select),"SQL injection");

        // despite what that answer says, I don't think  'sjis' and 'cp932' are vulnerable.. see here: http://stackoverflow.com/q/28705324/65387

        foreach(['big5', 'gb2312', 'gbk'] as $charset) {
            $conn = new \QueryBuilder\Connections\FakeMySqlConnection($charset, false);
            $this->assertSimilar("SELECT '\xbf\x27 OR 1=1 /*'", $conn->render($select), "SQL injection averted for $charset");
        }
    }

    function testFakeMySqlConnectionNoBackslashEscapes() {
        $select = (new Select())->fields(new Value("\"hello\"\r\n'world'"));
        $conn = new \QueryBuilder\Connections\FakeMySqlConnection('utf8', true);
        $this->assertSimilar("SELECT '\"hello\"\r\n''world'''",$conn->render($select));
    }

    function testFrom() {
        $select = (new Select())
            ->from(new Table('t1'), new Table('t2'), new Table('t3'))
            ->fields(new Asterisk)
        ;
        $this->assertSimilar("SELECT * FROM `t1`, `t2`, `t3`",$this->conn->render($select));
    }


    function testJoins() {
        $select = (new Select())
            ->from(new Table('t1'))
            ->fields(new Asterisk)
        ;
        $this->assertSimilar("SELECT * FROM `t1` INNER JOIN `t2` ON 2 LEFT JOIN `t3` ON 3 RIGHT JOIN `t4` ON 4 STRAIGHT_JOIN `t5` ON 5 NATURAL JOIN `t6` NATURAL LEFT JOIN `t7` NATURAL RIGHT JOIN `t8`",$this->conn->render($select->copy()
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
        $select = (new Select())->fields(new Asterisk)->from(new Table('t1'))->highPriority()->calcFoundRows()->distinct()->maxStatementTime(5)->straightJoinTables()->bufferResult()->noCache();
        $this->assertSimilar("SELECT DISTINCT HIGH_PRIORITY MAX_STATEMENT_TIME = 5 STRAIGHT_JOIN SQL_BUFFER_RESULT SQL_NO_CACHE SQL_CALC_FOUND_ROWS * FROM `t1`",$select->toSql($this->conn));

        $select = (new Select())->fields(new Asterisk)->from(new Table('t2'))->cache()->all();
        $this->assertSimilar("SELECT ALL SQL_CACHE * FROM `t2`",$select->toSql($this->conn));
    }

    function testJoinSubQuery() {
        $select = (new Select())
            ->from(new Table('t1'))
            ->fields(new Asterisk)
            ->innerJoin(new SubQueryTable(
                (new Select())
                    ->from(new Table('t2'))
                    ->fields(new Asterisk)
                ,new TableAlias('t2'))
            );

        $this->assertSimilar("SELECT * FROM `t1` INNER JOIN (SELECT * FROM `t2`) AS `t2`",$select->toSql($this->conn));
    }

    function testAsteriskWarning() {
        $this->setExpectedException(PHPUnit_Framework_Error_Warning::class, "unqualified *");
        (new Select())
            ->from(new Table('t1'))
            ->fields(new Asterisk, new Column('x'))->toSql($this->conn);
    }

    function testAsteriskWarningSuppression() {
        Select::suppressUnqualifiedAsteriskWarning();
        $select = (new Select())
            ->from(new Table('t1'))
            ->fields(new Asterisk, new Column('x'));
        $this->assertSimilar("SELECT *, `x` FROM `t1`",$select->toSql($this->conn));
        Select::suppressUnqualifiedAsteriskWarning(false);
    }

    function testSelectAsterisk() {
        $select = (new Select())
            ->from(new Table('t1'))
            ->fields(new Asterisk);
        $this->assertSimilar("SELECT * FROM `t1`",$select->toSql($this->conn)); // this test has to run on its own, otherwise it will generate a warning (see testAsteriskWarning)

        $select = (new Select())
            ->from(new Table('t1'))
            ->fields(new Asterisk('t1'), new Asterisk('db','t2'));

        $this->assertSimilar("SELECT `t1`.*, `db`.`t2`.* FROM `t1`",$select->toSql($this->conn));
    }

    function testLimit() {
        $select = (new Select())
            ->from(new Table('t1'))
            ->fields(new Asterisk);
        $this->assertSimilar("SELECT * FROM `t1` LIMIT 10",$select->limit(10)->toSql($this->conn));
        $this->assertSimilar("SELECT * FROM `t1` LIMIT 10 OFFSET 20",$select->offset(20)->toSql($this->conn));
        $this->assertSimilar("SELECT * FROM `t1` LIMIT 18446744073709551615 OFFSET 20",$select->limit(null)->toSql($this->conn));
    }

    function testUnion() {
        $select1 = (new Select())->from(new Table('t1'))->fields(new Column('c1'));
        $select2 = (new Select())->from(new Table('t2'))->fields(new Column('c2'));
        $select3 = (new Select())->from(new Table('t3'))->fields(new Column('c3'));
        $union = new Union();
        $union->push($select1);
        $union->push($select2);
        $this->assertSimilar("(SELECT `c1` FROM `t1`) UNION (SELECT `c2` FROM `t2`) UNION (SELECT `c3` FROM `t3`) LIMIT 50 OFFSET 100",$union->copy()->limit(50)->offset(100)->push($select3)->toSql($this->conn));
        $this->assertSimilar("(SELECT `c1` FROM `t1`) UNION (SELECT `c2` FROM `t2`)",$union->toSql($this->conn));

        $unionAll = new UnionAll();
        $unionAll->push($select1);
        $unionAll->push($select2);
        $this->assertSimilar("(SELECT `c1` FROM `t1`) UNION ALL (SELECT `c2` FROM `t2`) UNION ALL (SELECT `c3` FROM `t3`) LIMIT 50 OFFSET 100",$unionAll->copy()->limit(50)->offset(100)->push($select3)->toSql($this->conn));
        $this->assertSimilar("(SELECT `c1` FROM `t1`) UNION ALL (SELECT `c2` FROM `t2`)",$unionAll->toSql($this->conn));

        $countAlias = new FieldAlias('count');
        $unionCount = (new UnionAll(
            (new Select())->from(new Table('t1'))->fields(new FieldAsAlias(Count::all(),$countAlias)),
            (new Select())->from(new Table('t2'))->fields(Count::all())
        ));
        $select = (new Select())->fields(new Sum(new Column('xyz')));//->from(new SubQueryAlias(new SubQuery($unionCount),'master'));

        //var_dump($unionCount->toSql($this->conn));
        //var_dump($select->toSql($this->conn));
    }



    function testSelect() {
        $dual = new \QueryBuilder\RawTable('DUAL');

        $select = (new Select())
            ->fields(new Asterisk)
            ->from(new Table('wx_user'));
        $this->assertSimilar("SELECT * FROM `wx_user`",$select->toSql($this->conn));

        $select = (new Select())
            ->fields(new Column('wx_eafk_dso','client','ecl_name'), new FieldAsAlias(new Column('client','ecl_birth_date'),new FieldAlias('dob')))
            ->from(new TableAsAlias(new Table('wx_eafk_dso','emr_client'),new FieldAlias('client')));
        $this->assertSimilar("SELECT `wx_eafk_dso`.`client`.`ecl_name`, `client`.`ecl_birth_date` AS `dob` FROM `wx_eafk_dso`.`emr_client` AS `client`",$select->toSql($this->conn));

        $select = (new Select())
            ->fields(new Asterisk)
            ->from($dual);
        $this->assertSimilar("SELECT * FROM DUAL",$select->toSql($this->conn));



        $select = (new Select())
            ->fields(new Exists((new Select())
                ->fields(new Asterisk)
                ->from($dual)
                ->where(new RawExpr('0')))
            );
        $this->assertSimilar("SELECT EXISTS(SELECT * FROM DUAL WHERE 0)",$select->toSql($this->conn));


        $select = (new Select())
            ->fields(new AndNode(new RawExpr('0'),new RawExpr('1'),new RawExpr('2'),new AndNode(new RawExpr('3'),new RawExpr('4'),new OrNode(new RawExpr('5'),new RawExpr('6'),new ConcatNode()))));
        $this->assertSimilar("SELECT 0 AND 1 AND 2 AND 3 AND 4 AND (5 OR 6)",$select->toSql($this->conn));

        //$select = (new SelectStmt())->select(new Value(null), new Value(1), new Value(3.14), new Value(new \DateTime('1999-12-31 23:59:59')));
        //$this->assertSimilar("SELECT NULL, 1, 3.14, '1999-12-31 23:59:59'",$this->conn->render($select));

        //$select = (new SelectStmt())->from(new TableRef('table'))->select(new Asterisk)->where(new Param('bacon'));
        //var_dump($select->toSql($this->mySql));
        //exit;

        //var_dump($select->toSql($this->mySql));
        // todo: reproduce this: SELECT EXISTS(SELECT * FROM DUAL WHERE 0)
        // (new SelectStmt())->select(new SubQuery('exists')->
    }
}
