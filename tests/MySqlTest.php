<?php
use QueryBuilder\Database;
use QueryBuilder\FieldAlias;
use QueryBuilder\Asterisk;
use QueryBuilder\Column;
use QueryBuilder\FieldAs;
use QueryBuilder\Connections\AbstractMySqlConnection;
use QueryBuilder\Dual;
use QueryBuilder\Functions\Count;
use QueryBuilder\Functions\Exists;
use QueryBuilder\Functions\Sum;
use QueryBuilder\Operator\Add;
use QueryBuilder\Operator\Assign;
use QueryBuilder\Operator\Bang;
use QueryBuilder\Operator\Between;
use QueryBuilder\Operator\Div;
use QueryBuilder\Operator\Equal;
use QueryBuilder\Operator\IntDiv;
use QueryBuilder\Operator\LessThan;
use QueryBuilder\Operator\LogicalAnd;
use QueryBuilder\Operator\LogicalOr;
use QueryBuilder\Operator\LogicalXor;
use QueryBuilder\Operator\LShift;
use QueryBuilder\Operator\Mod;
use QueryBuilder\Operator\Mult;
use QueryBuilder\Operator\Not;
use QueryBuilder\Operator\Pipes;
use QueryBuilder\Operator\RShift;
use QueryBuilder\Operator\Sub;
use QueryBuilder\Order;
use QueryBuilder\Param;
use QueryBuilder\Statements\Select;
use QueryBuilder\Statements\Union;
use QueryBuilder\Statements\UnionAll;
use QueryBuilder\SubQueryTable;
use QueryBuilder\Table;
use QueryBuilder\TableAlias;
use QueryBuilder\TableAs;
use QueryBuilder\Value;
use QueryBuilder\Variable;

class MySqlTest extends TestCase {
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
        $this->assertSame('`table`.`column`',(new Column('column',new Table('table')))->toSql($this->conn));
        $this->assertSame('`schema`.`table`.`column`',(new Column('column',new Table('table',new Database('schema'))))->toSql($this->conn));
        $this->assertSame('`sch``ema`.`tab.le`.`col"umn`',(new Column('col"umn',new Table('tab.le',new Database('sch`ema'))))->toSql($this->conn));
    }

    //function testSpecialValues() {
    //    $this->assertSame(new Asterisk, new Asterisk, "Repeated calls to new Asterisk should return the same instance");
    //    $this->assertSame(Dual::value(), Dual::value(), "Repeated calls to Dual::value() should return the same instance");
    //}

    function testParam() {
        $select = (new Select())
            ->fields(new Param, new Param('name'), new Param(null,3), new Param('count',3))
            ->from(new Table('table'));

        $this->assertSame("SELECT ?, :name, ?, ?, ?, :count0, :count1, :count2 FROM `table`",$this->conn->render($select));
    }

    function testParamException() {
        $this->setExpectedException(Exception::class);
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
            ->fields(new Asterisk)
        ;
        $this->assertSame("SELECT * FROM `t1`, `t2`, `t3`",$this->conn->render($select));
    }


    function testJoins() {
        $select = (new Select())
            ->from(new Table('t1'))
            ->fields(new Asterisk)
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
        $select = (new Select())->fields(new Asterisk)->from(new Table('t1'))->highPriority()->calcFoundRows()->distinct()->maxStatementTime(5)->straightJoinTables()->bufferResult()->noCache();
        $this->assertSame("SELECT DISTINCT HIGH_PRIORITY MAX_STATEMENT_TIME = 5 STRAIGHT_JOIN SQL_BUFFER_RESULT SQL_NO_CACHE SQL_CALC_FOUND_ROWS * FROM `t1`",$select->toSql($this->conn));

        $select = (new Select())->fields(new Asterisk)->from(new Table('t2'))->cache()->all();
        $this->assertSame("SELECT ALL SQL_CACHE * FROM `t2`",$select->toSql($this->conn));
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

        $this->assertSame("SELECT * FROM `t1` INNER JOIN (SELECT * FROM `t2`) AS `t2`",$select->toSql($this->conn));
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
        $this->assertSame("SELECT *, `x` FROM `t1`",$select->toSql($this->conn));
        Select::suppressUnqualifiedAsteriskWarning(false);
    }

    function testSelectAsterisk() {
        $table1 = new Table('t1');
        $select = (new Select())
            ->from($table1)
            ->fields(new Asterisk);
        $this->assertSame("SELECT * FROM `t1`",$select->toSql($this->conn)); // this test has to run on its own, otherwise it will generate a warning (see testAsteriskWarning)

        $table2 = new Table('t2',new Database('db'));
        $select = (new Select())
            ->from($table1)
            ->fields(new Asterisk($table1), new Asterisk($table2));

        $this->assertSame("SELECT `t1`.*, `db`.`t2`.* FROM `t1`",$select->toSql($this->conn));
    }

    function testLimit() {
        $select = (new Select())
            ->from(new Table('t1'))
            ->fields(new Asterisk);
        $this->assertSame("SELECT * FROM `t1` LIMIT 10",$select->limit(10)->toSql($this->conn));
        $this->assertSame("SELECT * FROM `t1` LIMIT 10 OFFSET 20",$select->offset(20)->toSql($this->conn));
        $this->assertSame("SELECT * FROM `t1` LIMIT 18446744073709551615 OFFSET 20",$select->limit(null)->toSql($this->conn));
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
            (new Select())->from(new Table('t1'))->fields(new FieldAs(Count::all(),$countAlias)),
            (new Select())->from(new Table('t2'))->fields(Count::all())
        ));
        $select = (new Select())->fields(new Sum($countAlias))->from(new SubQueryTable($unionCount,new TableAlias('t3')));

        $this->assertSimilar("SELECT SUM(`count`) FROM ((SELECT COUNT(*) AS `count` FROM `t1`) UNION ALL (SELECT COUNT(*) FROM `t2`)) AS `t3`",$select->toSql($this->conn),"total number of rows across multiple tables");

        //var_dump($unionCount->toSql($this->conn));
        //var_dump($select->toSql($this->conn));
    }

    function testOrderBy() {
        $select = (new Select())->fields(new Asterisk)->orderBy(new Value(2), new Value(3))->appendOrderBy(new Value(4))->prependOrderBy(new Value(1));
        $this->assertSimilar("SELECT * ORDER BY 1, 2, 3, 4",$select->toSql($this->conn));

        $alias = new FieldAlias('vegetable');
        $select = (new Select())->fields(new FieldAs(new Column('bacon'),$alias))->orderBy(new Order($alias,Order::DESC));
        $this->assertSimilar("SELECT `bacon` AS `vegetable` ORDER BY `vegetable` DESC",$select->toSql($this->conn));
    }

    function testOperators() {
        $zero = new Value(0);
        $one = new Value(1);
        $two = new Value(2);
        $three = new Value(3);
        $four = new Value(4);
        $five = new Value(5);
        $this->assertSimilar("SELECT 1 + 2 * 3",(new Select())->fields(new Add($one,new Mult($two, $three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 * (2 + 3)",(new Select())->fields(new Mult($one,new Add($two, $three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 << 2 << 3",(new Select())->fields(new LShift($one, $two, $three))->toSql($this->conn));
        $this->assertSimilar("SELECT (1 << 2) + 3",(new Select())->fields(new Add(new LShift($one, $two), $three))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 + 2 << 3",(new Select())->fields(new LShift(new Add($one, $two), $three))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 << 2 << 3",(new Select())->fields(new LShift(new LShift($one, $two), $three))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 << (2 << 3)",(new Select())->fields(new LShift($one,new LShift($two, $three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 >> 2 << 3",(new Select())->fields(new LShift(new RShift($one, $two), $three))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 << (2 >> 3)",(new Select())->fields(new LShift($one,new RShift($two, $three)))->toSql($this->conn));
        $this->assertSimilar("SELECT !(1 + 2)",(new Select())->fields(new Bang(new Add($one, $two)))->toSql($this->conn));
        $this->assertSimilar("SELECT NOT 1 + 2",(new Select())->fields(new Not(new Add($one, $two)))->toSql($this->conn)); // same as NOT(1+2)
        $this->assertSimilar("SELECT !(NOT 0)",(new Select())->fields(new Bang(new Not($zero)))->toSql($this->conn));
        $this->assertSimilar("SELECT NOT !0",(new Select())->fields(new Not(new Bang($zero)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 + (NOT 0)",(new Select())->fields(new Add($one,new Not($zero)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 + !0",(new Select())->fields(new Add($one,new Bang($zero)))->toSql($this->conn));
        $this->assertSimilar("SELECT !(0 << 1)",(new Select())->fields(new Bang(new LShift($zero,$one)))->toSql($this->conn));
        $this->assertSimilar("SELECT NOT 0 << 1",(new Select())->fields(new Not(new LShift($zero,$one)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 + 2 + 3",(new Select())->fields(new Add($one,new Add($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 - (2 - 3)",(new Select())->fields(new Sub($one,new Sub($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 % (2 % 3)",(new Select())->fields(new Mod($one,new Mod($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 * 2 * 3",(new Select())->fields(new Mult($one,new Mult($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 / (2 / 3)",(new Select())->fields(new Div($one,new Div($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 * (2 / 3)",(new Select())->fields(new Mult($one,new Div($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 / (2 * 3)",(new Select())->fields(new Div($one,new Mult($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 DIV (2 DIV 3)",(new Select())->fields(new IntDiv($one,new IntDiv($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 < (2 < 3)",(new Select())->fields(new LessThan($one,new LessThan($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 4 BETWEEN (2 BETWEEN 1 AND 3) AND 5",(new Select())->fields(new Between($four,new Between($two,$one,$three),$five))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 = (2 = 2)",(new Select())->fields(new Equal($one,new Equal($two,$two)))->toSql($this->conn));

        $select = (new Select())->fields(new LogicalAnd(new Value(0),new Value(1),new Value(2),new LogicalAnd(new Value(3),new Value(4),new LogicalOr(new Value(5),new Value(6),new Pipes()))));
        $this->assertSame("SELECT 0 AND 1 AND 2 AND 3 AND 4 AND (5 OR 6)",$select->toSql($this->conn));

        $select = (new Select())->fields(new Assign(new Variable('x'),new LogicalOr($zero,new LogicalXor($one, new LogicalAnd($two,new Not($three))))));
        $this->assertSame("SELECT @x := 0 OR 1 XOR 2 AND NOT 3",$select->toSql($this->conn));

        $select = (new Select())->fields(new LogicalAnd($two,new LogicalXor($zero,new LogicalOr($one, new Assign(new Variable('x'),new Not($three))))));
        $this->assertSame("SELECT 2 AND (0 XOR (1 OR (@x := NOT 3)))",$select->toSql($this->conn));
    }

    function testSelect() {
        $dual = new Dual;

        $select = (new Select())
            ->fields(new Asterisk)
            ->from(new Table('wx_user'));
        $this->assertSame("SELECT * FROM `wx_user`",$select->toSql($this->conn));

        $eafkDatabase = new Database('wx_eafk_dso');
        $clientTable = new Table('emr_client',$eafkDatabase);
        $clientAlias = new TableAlias('client');
        $select = (new Select())
            ->fields(new Column('ecl_name',$clientTable), new FieldAs(new Column('ecl_birth_date',$clientAlias),new FieldAlias('dob')))
            ->from(new TableAs(new Table('emr_client', $eafkDatabase), $clientAlias));
        $this->assertSame("SELECT `wx_eafk_dso`.`emr_client`.`ecl_name`, `client`.`ecl_birth_date` AS `dob` FROM `wx_eafk_dso`.`emr_client` AS `client`",$select->toSql($this->conn));

        $select = (new Select())
            ->fields(new Asterisk)
            ->from($dual);
        $this->assertSame("SELECT * FROM DUAL",$select->toSql($this->conn));



        $select = (new Select())
            ->fields(new Exists((new Select())
                ->fields(new Asterisk)
                ->from($dual)
                ->where(new Value(0)))
            );
        $this->assertSame("SELECT EXISTS(SELECT * FROM DUAL WHERE 0)",$select->toSql($this->conn));




        //$select = (new SelectStmt())->select(new Value(null), new Value(1), new Value(3.14), new Value(new \DateTime('1999-12-31 23:59:59')));
        //$this->assertSame("SELECT NULL, 1, 3.14, '1999-12-31 23:59:59'",$this->conn->render($select));

        //$select = (new SelectStmt())->from(new TableRef('table'))->select(new Asterisk)->where(new Param('bacon'));
        //var_dump($select->toSql($this->mySql));
        //exit;

        //var_dump($select->toSql($this->mySql));
        // todo: reproduce this: SELECT EXISTS(SELECT * FROM DUAL WHERE 0)
        // (new SelectStmt())->select(new SubQuery('exists')->
    }
}
