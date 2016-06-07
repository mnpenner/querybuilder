<?php
use QueryBuilder\Asterisk;
use function QueryBuilder\col;
use function QueryBuilder\colAs;
use QueryBuilder\Column;
use function QueryBuilder\columns;
use QueryBuilder\Connections\AbstractMySqlConnection;
use QueryBuilder\Database;
use QueryBuilder\Dual;
use function QueryBuilder\eq;
use function QueryBuilder\eqCols;
use function QueryBuilder\eqColVal;
use QueryBuilder\FieldAlias;
use QueryBuilder\ExprAs;
use QueryBuilder\Functions\UserFunc;
use QueryBuilder\Functions\Stmt;
use QueryBuilder\HexLiteral;
use QueryBuilder\Interval;
use QueryBuilder\MySql\Functions\Agg;
use QueryBuilder\MySql\Functions\Math;
use QueryBuilder\MySql\Functions\Str;
use QueryBuilder\MySql\Keywords\Charset;
use QueryBuilder\MySql\Keywords\Collation;
use QueryBuilder\Operator\Add;
use QueryBuilder\Operator\Assign;
use QueryBuilder\Operator\GreaterThan;
use QueryBuilder\Operator\Negate;
use QueryBuilder\Operator\Between;
use QueryBuilder\Operator\BitOr;
use QueryBuilder\Operator\Div;
use QueryBuilder\Operator\Equal;
use QueryBuilder\Operator\IntDiv;
use QueryBuilder\Operator\LessThan;
use QueryBuilder\Operator\LogAnd;
use QueryBuilder\Operator\LogOr;
use QueryBuilder\Operator\LogXor;
use QueryBuilder\Operator\LShift;
use QueryBuilder\Operator\Mod;
use QueryBuilder\Operator\Mult;
use QueryBuilder\Operator\Not;
use QueryBuilder\Operator\Pipes;
use QueryBuilder\Operator\RShift;
use QueryBuilder\Operator\Sub;
use QueryBuilder\Order;
use QueryBuilder\Param;
use function QueryBuilder\selectAs;
use QueryBuilder\Statements\Select;
use QueryBuilder\Statements\Union;
use QueryBuilder\Statements\UnionAll;
use QueryBuilder\StringLiteral;
use QueryBuilder\SelectTable;
use QueryBuilder\Table;
use QueryBuilder\TableAlias;
use QueryBuilder\TableAs;
use function QueryBuilder\talias;
use function QueryBuilder\tbl;
use function QueryBuilder\val;
use function QueryBuilder\values;
use function QueryBuilder\exprAs as exprAlias;
use QueryBuilder\Value;
use QueryBuilder\UserVariable;

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
        $this->assertSimilar('`table`.`column`',(new Column('column',new Table('table')))->toSql($this->conn));
        $this->assertSimilar('`schema`.`table`.`column`',(new Column('column',new Table('table',new Database('schema'))))->toSql($this->conn));
        $this->assertSimilar('`sch``ema`.`tab.le`.`col"umn`',(new Column('col"umn',new Table('tab.le',new Database('sch`ema'))))->toSql($this->conn));
    }

    //function testSpecialValues() {
    //    $this->assertSimilar(new Asterisk, new Asterisk, "Repeated calls to new Asterisk should return the same instance");
    //    $this->assertSimilar(Dual::value(), Dual::value(), "Repeated calls to Dual::value() should return the same instance");
    //}

    function testParam() {
        $select = (new Select())
            ->select(new Param, new Param('name'), new Param(null,3), new Param('count',3))
            ->from(new Table('table'));

        $this->assertSimilar("SELECT ?, :name, ?, ?, ?, :count0, :count1, :count2 FROM `table`",$this->conn->render($select));
    }

    function testParamException() {
        $this->setExpectedException(Exception::class);
        new Param(null,-1);
    }

    function testValue() {
        $select = (new Select())->select(new Value(null), new Value(1), new Value(3.14), new Value(new \DateTime('1999-12-31 23:59:59')));
        $this->assertSimilar("SELECT NULL, 1, 3.14, '1999-12-31 23:59:59'",$this->conn->render($select));
    }

    function testFakeMySqlConnectionInjection() {
        $iso8859conn = new \QueryBuilder\Connections\FakeMySqlConnection('iso-8859-1', false);

        // 0x5c = \
        // 0x27 = '

        // if the server charset is actually `gbk` then 0xbf5c will be interpreted as a single character,
        // and this query will actually look something like: SELECT * FROM test WHERE name = '縗' OR 1=1 /*' LIMIT 1
        // which of course a successful SQL injection attack; see http://stackoverflow.com/a/12118602/65387
        $select1 = (new Select())->select(new Value("\xbf\x27 OR 1=1 /*"));
        $this->assertSimilar("SELECT '\xbf\x5c\x27 OR 1=1 /*'",$iso8859conn->render($select1),"SQL injection");

        foreach(['big5', 'gb2312', 'gbk'] as $charset) {
            $big5conn = new \QueryBuilder\Connections\FakeMySqlConnection($charset, false);
            $this->assertSimilar("SELECT '\xbf\x27 OR 1=1 /*'", $big5conn->render($select1), "SQL injection averted for $charset");
        }


        // mb_strlen("\x83\x27", 'iso-8859-1') === 2
        // mb_strlen("\x83\x27", 'cp932') === 1
        // mb_strlen("\x83\x27", 'sjis') === 1
        // mb_strlen("\x83\x27", 'big5') === 1
        // mb_strlen("\x83\x27", 'gb2312') === 2
        // mb_strlen("\x83\x27", 'gbk') === 1
        $select2 = (new Select())->select(new Value("\x83\x27 OR 1=1 /*"));
        $this->assertSimilar("SELECT '\x83\x5c\x27 OR 1=1 /*'",$iso8859conn->render($select1),"SQL injection");

        foreach(['cp932', 'sjis'] as $charset) {
            $cp932conn = new \QueryBuilder\Connections\FakeMySqlConnection($charset, false);
            $this->assertSimilar("SELECT '\x83\x27 OR 1=1 /*'", $cp932conn->render($select2), "SQL injection averted for $charset");
        }
    }

    function testFakeMySqlConnectionNoBackslashEscapes() {
        $select = (new Select())->select(new Value("\"hello\"\r\n'world'"));
        $conn = new \QueryBuilder\Connections\FakeMySqlConnection('utf8', true);
        $this->assertSimilar("SELECT '\"hello\"\r\n''world'''",$conn->render($select));
    }

    function testFrom() {
        $select = (new Select())
            ->from(new Table('t1'), new Table('t2'), new Table('t3'))
            ->select(new Asterisk)
        ;
        $this->assertSimilar("SELECT * FROM `t1`, `t2`, `t3`",$this->conn->render($select));
    }


    function testJoins() {
        $select = (new Select())
            ->from(new Table('t1'))
            ->select(new Asterisk)
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
        $select = (new Select())->select(new Asterisk)->from(new Table('t1'))->highPriority()->calcFoundRows()->distinct()->maxStatementTime(5)->straightJoinTables()->bufferResult()->noCache();
        $this->assertSimilar("SELECT DISTINCT HIGH_PRIORITY MAX_STATEMENT_TIME = 5 STRAIGHT_JOIN SQL_BUFFER_RESULT SQL_NO_CACHE SQL_CALC_FOUND_ROWS * FROM `t1`",$select->toSql($this->conn));

        $select = (new Select())->select(new Asterisk)->from(new Table('t2'))->cache()->all();
        $this->assertSimilar("SELECT ALL SQL_CACHE * FROM `t2`",$select->toSql($this->conn));
    }

    function testJoinSubQuery() {
        $select = (new Select())
            ->from(new Table('t1'))
            ->select(new Asterisk)
            ->innerJoin(new SelectTable(
                (new Select())
                    ->from(new Table('t2'))
                    ->select(new Asterisk)
                ,new TableAlias('t2'))
            );

        $this->assertSimilar("SELECT * FROM `t1` INNER JOIN (SELECT * FROM `t2`) AS `t2`",$select->toSql($this->conn));
    }

    function testAsteriskNoError() {
        (new Select())
            ->from(new Table('t1'))
            ->select(new Asterisk, new Column('x'))->toSql($this->conn);
    }

    function testAsteriskError() {
        $this->setExpectedException(\Exception::class, "unqualified *");
        (new Select())
            ->from(new Table('t1'))
            ->select(new Column('x'),new Asterisk)->toSql($this->conn);
    }

//    function testAsteriskWarningSuppression() {
//        Select::suppressUnqualifiedAsteriskWarning();
//        $select = (new Select())
//            ->from(new Table('t1'))
//            ->fields(new Asterisk, new Column('x'));
//        $this->assertSimilar("SELECT *, `x` FROM `t1`",$select->toSql($this->conn));
//        Select::suppressUnqualifiedAsteriskWarning(false);
//    }

    function testSelectAsterisk() {
        $table1 = new Table('t1');
        $select = (new Select())
            ->from($table1)
            ->select(new Asterisk);
        $this->assertSimilar("SELECT * FROM `t1`",$select->toSql($this->conn)); // this test has to run on its own, otherwise it will generate a warning (see testAsteriskWarning)

        $table2 = new Table('t2',new Database('db'));
        $select = (new Select())
            ->from($table1)
            ->select(new Asterisk($table1), new Asterisk($table2));

        $this->assertSimilar("SELECT `t1`.*, `db`.`t2`.* FROM `t1`",$select->toSql($this->conn));
    }

    function testLimit() {
        $select = (new Select())
            ->from(new Table('t1'))
            ->select(new Asterisk);
        $this->assertSimilar("SELECT * FROM `t1` LIMIT 10",$select->limit(10)->toSql($this->conn));
        $this->assertSimilar("SELECT * FROM `t1` LIMIT 10 OFFSET 20",$select->offset(20)->toSql($this->conn));
        $this->assertSimilar("SELECT * FROM `t1` LIMIT 18446744073709551615 OFFSET 20",$select->limit(null)->toSql($this->conn));
    }

    function testUnion() {
        $select1 = (new Select())->from(new Table('t1'))->select(new Column('c1'));
        $select2 = (new Select())->from(new Table('t2'))->select(new Column('c2'));
        $select3 = (new Select())->from(new Table('t3'))->select(new Column('c3'));
        $union = new Union();
        $union->push($select1);
        $union->push($select2);
        $this->assertSimilar("SELECT `c1` FROM `t1` UNION SELECT `c2` FROM `t2` UNION SELECT `c3` FROM `t3` LIMIT 50 OFFSET 100",$union->copy()->limit(50)->offset(100)->push($select3)->toSql($this->conn));
        $this->assertSimilar("SELECT `c1` FROM `t1` UNION SELECT `c2` FROM `t2`",$union->toSql($this->conn));

        $unionAll = new UnionAll();
        $unionAll->push($select1);
        $unionAll->push($select2);
        $this->assertSimilar("SELECT `c1` FROM `t1` UNION ALL SELECT `c2` FROM `t2` UNION ALL SELECT `c3` FROM `t3` LIMIT 50 OFFSET 100",$unionAll->copy()->limit(50)->offset(100)->push($select3)->toSql($this->conn));
        $this->assertSimilar("SELECT `c1` FROM `t1` UNION ALL SELECT `c2` FROM `t2`",$unionAll->toSql($this->conn));

        $countAlias = new FieldAlias('count');
        $unionCount = (new UnionAll(
            (new Select())->from(new Table('t1'))->select(new ExprAs(Agg::countRows(),$countAlias)),
            (new Select())->from(new Table('t2'))->select(Agg::countRows())
        ));
        $select = (new Select())->select(Agg::sum($countAlias))->from(new SelectTable($unionCount,new TableAlias('t3')));

        $this->assertSimilar("SELECT SUM(`count`) FROM (SELECT COUNT(*) AS `count` FROM `t1` UNION ALL SELECT COUNT(*) FROM `t2`) AS `t3`",$select->toSql($this->conn),"total number of rows across multiple tables");

        //var_dump($unionCount->toSql($this->conn));
        //var_dump($select->toSql($this->conn));
    }

    function testOrderBy() {
        $select = (new Select())->select(new Asterisk)->orderBy(new Value(2), new Value(3))->appendOrderBy(new Value(4))->prependOrderBy(new Value(1));
        $this->assertSimilar("SELECT * ORDER BY 1, 2, 3, 4",$select->toSql($this->conn));

        $alias = new FieldAlias('vegetable');
        $select = (new Select())->select(new ExprAs(new Column('bacon'),$alias))->orderBy(new Order($alias,Order::DESC));
        $this->assertSimilar("SELECT `bacon` AS `vegetable` ORDER BY `vegetable` DESC",$select->toSql($this->conn));

        $select = (new Select())
            ->select(new Column('college'), new Column('region'), new Column('seed'))
            ->from(new Table('tournament'))
            ->orderBy(new Value(2), new Value(3));
        $this->assertSimilar("SELECT `college`, `region`, `seed` FROM `tournament` ORDER BY 2, 3",$select->toSql($this->conn));
    }

    function testGroupBy() {
        $a = new Column('a');
        $b = new Column('b');
        $select = (new Select())->select($a,Agg::countNonNull($b))->from(new Table('test_table'))->groupBy($a);
        $this->assertSimilar("SELECT `a`, COUNT(`b`) FROM `test_table` GROUP BY `a`",$select->toSql($this->conn));

        $select = (new Select())->select($a,Agg::countNonNull($b))->from(new Table('test_table'))->groupBy(new Order($a,Order::DESC));
        $this->assertSimilar("SELECT `a`, COUNT(`b`) FROM `test_table` GROUP BY `a` DESC",$select->toSql($this->conn));

        $select = (new Select())
            ->select($a,Agg::countNonNull($b))
            ->from(new Table('test_table'))
            ->groupBy(new Order($a,Order::DESC),$b)
            ->orderBy(new Value(null));
        $this->assertSimilar("SELECT `a`, COUNT(`b`) FROM `test_table` GROUP BY `a` DESC, `b` ORDER BY NULL",$select->toSql($this->conn));
    }

    function testOperators() {
        $zero = new Value(0);
        $one = new Value(1);
        $two = new Value(2);
        $three = new Value(3);
        $four = new Value(4);
        $five = new Value(5);
        
        $this->assertSimilar("SELECT 1 + 2 * 3",(new Select())->select(new Add($one,new Mult($two, $three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 * (2 + 3)",(new Select())->select(new Mult($one,new Add($two, $three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 << 2 << 3",(new Select())->select(new LShift($one, $two, $three))->toSql($this->conn));
        $this->assertSimilar("SELECT (1 << 2) + 3",(new Select())->select(new Add(new LShift($one, $two), $three))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 + 2 << 3",(new Select())->select(new LShift(new Add($one, $two), $three))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 << 2 << 3",(new Select())->select(new LShift(new LShift($one, $two), $three))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 << (2 << 3)",(new Select())->select(new LShift($one,new LShift($two, $three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 >> 2 << 3",(new Select())->select(new LShift(new RShift($one, $two), $three))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 << (2 >> 3)",(new Select())->select(new LShift($one,new RShift($two, $three)))->toSql($this->conn));
        $this->assertSimilar("SELECT !(1 + 2)",(new Select())->select(new Negate(new Add($one, $two)))->toSql($this->conn));
        $this->assertSimilar("SELECT NOT 1 + 2",(new Select())->select(new Not(new Add($one, $two)))->toSql($this->conn)); // same as NOT(1+2)
        $this->assertSimilar("SELECT !(NOT 0)",(new Select())->select(new Negate(new Not($zero)))->toSql($this->conn));
        $this->assertSimilar("SELECT NOT !0",(new Select())->select(new Not(new Negate($zero)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 + (NOT 0)",(new Select())->select(new Add($one,new Not($zero)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 + !0",(new Select())->select(new Add($one,new Negate($zero)))->toSql($this->conn));
        $this->assertSimilar("SELECT !(0 << 1)",(new Select())->select(new Negate(new LShift($zero,$one)))->toSql($this->conn));
        $this->assertSimilar("SELECT NOT 0 << 1",(new Select())->select(new Not(new LShift($zero,$one)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 + 2 + 3",(new Select())->select(new Add($one,new Add($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 - (2 - 3)",(new Select())->select(new Sub($one,new Sub($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 % (2 % 3)",(new Select())->select(new Mod($one,new Mod($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 * 2 * 3",(new Select())->select(new Mult($one,new Mult($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 / (2 / 3)",(new Select())->select(new Div($one,new Div($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 / 2 / 3",(new Select())->select(new Div(new Div($one,$two),$three))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 * (2 / 3)",(new Select())->select(new Mult($one,new Div($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 * 2 / 3",(new Select())->select(new Div(new Mult($one,$two),$three))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 / (2 * 3)",(new Select())->select(new Div($one,new Mult($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 DIV (2 DIV 3)",(new Select())->select(new IntDiv($one,new IntDiv($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 < (2 < 3)",(new Select())->select(new LessThan($one,new LessThan($two,$three)))->toSql($this->conn));
        $this->assertSimilar("SELECT 4 BETWEEN (2 BETWEEN 1 AND 3) AND 5",(new Select())->select(new Between($four,new Between($two,$one,$three),$five))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 = (2 = 2)",(new Select())->select(new Equal($one,new Equal($two,$two)))->toSql($this->conn));
        $this->assertSimilar("SELECT @a := @b := 3",(new Select())->select(new Assign(new UserVariable('a'),new Assign(new UserVariable('b'),$three)))->toSql($this->conn));

        $select = (new Select())->select(new LogAnd(new Value(0),new Value(1),new Value(2),new LogAnd(new Value(3),new Value(4),new LogOr(new Value(5),new Value(6)))));
        $this->assertSimilar("SELECT 0 AND 1 AND 2 AND 3 AND 4 AND (5 OR 6)",$select->toSql($this->conn));

        $select = (new Select())->select(new Assign(new UserVariable('x'),new LogOr($zero,new LogXor($one, new LogAnd($two,new Not($three))))));
        $this->assertSimilar("SELECT @x := 0 OR 1 XOR 2 AND NOT 3",$select->toSql($this->conn));

        $select = (new Select())->select(new LogAnd($two,new LogXor($zero,new LogOr($one, new Assign(new UserVariable('x'),new Not($three))))));
        $this->assertSimilar("SELECT 2 AND (0 XOR (1 OR (@x := NOT 3)))",$select->toSql($this->conn));

        $this->assertSimilar("SELECT '2008-12-31 23:59:59' + INTERVAL 1 SECOND",Stmt::select()->select(new Add(new Value('2008-12-31 23:59:59'),new Interval(new Value(1), Interval::SECOND())))->toSql($this->conn));
        $this->assertSimilar("SELECT INTERVAL 1 DAY + '2008-12-31'",Stmt::select()->select(new Add(new Interval(new Value(1), Interval::DAY()),new Value('2008-12-31')))->toSql($this->conn));
    }

    function testSelect() {
        $dual = new Dual;

        $select = (new Select())
            ->select(new Asterisk)
            ->from(new Table('wx_user'));
        $this->assertSimilar("SELECT * FROM `wx_user`",$select->toSql($this->conn));

        $eafkDatabase = new Database('wx_eafk_dso');
        $clientTable = new Table('emr_client',$eafkDatabase);
        $clientAlias = new TableAlias('client');
        $select = (new Select())
            ->select(new Column('ecl_name',$clientTable), new ExprAs(new Column('ecl_birth_date',$clientAlias),new FieldAlias('dob')))
            ->from(new TableAs(new Table('emr_client', $eafkDatabase), $clientAlias));
        $this->assertSimilar("SELECT `wx_eafk_dso`.`emr_client`.`ecl_name`, `client`.`ecl_birth_date` AS `dob` FROM `wx_eafk_dso`.`emr_client` AS `client`",$select->toSql($this->conn));

        $select = (new Select())
            ->select(new Asterisk)
            ->from($dual);
        $this->assertSimilar("SELECT * FROM DUAL",$select->toSql($this->conn));



        $select = (new Select())
            ->select(Agg::exists((new Select())
                ->select(new Asterisk)
                ->from($dual)
                ->where(new Value(0)))
            );
        $this->assertSimilar("SELECT EXISTS(SELECT * FROM DUAL WHERE 0)",$select->toSql($this->conn));




        //$select = (new SelectStmt())->select(new Value(null), new Value(1), new Value(3.14), new Value(new \DateTime('1999-12-31 23:59:59')));
        //$this->assertSimilar("SELECT NULL, 1, 3.14, '1999-12-31 23:59:59'",$this->conn->render($select));

        //$select = (new SelectStmt())->from(new TableRef('table'))->select(new Asterisk)->where(new Param('bacon'));
        //var_dump($select->toSql($this->mySql));
        //exit;

        //var_dump($select->toSql($this->mySql));
        // todo: reproduce this: SELECT EXISTS(SELECT * FROM DUAL WHERE 0)
        // (new SelectStmt())->select(new SubQuery('exists')->
    }

    function testMathFuncs() {
        $one = new Value(1);
        $two = new Value(2);
        $this->assertSimilar('SELECT ABS(2)',(new Select())->select(Math::abs($two))->toSql($this->conn));
        $this->assertSimilar('SELECT ACOS(1)',(new Select())->select(Math::acos($one))->toSql($this->conn));
        $this->assertSimilar('SELECT ATAN(2)',(new Select())->select(Math::atan($two))->toSql($this->conn));
        $this->assertSimilar('SELECT ATAN(-2, 2)',(new Select())->select(Math::atan(new Value(-2), $two))->toSql($this->conn));
        $this->assertSimilar('SELECT ATAN2(-2, 2)',(new Select())->select(Math::atan2(new Value(-2), $two))->toSql($this->conn));
        $this->assertSimilar('SELECT CEILING(1.23)',(new Select())->select(Math::ceil(new Value(1.23)))->toSql($this->conn));
        $this->assertSimilar("SELECT CONV('a', 16, 2)",(new Select())->select(Math::conv(new Value('a'), new Value(16), $two))->toSql($this->conn));
        $this->assertSimilar("SELECT COS(1)",(new Select())->select(Math::cos($one))->toSql($this->conn));
        $this->assertSimilar("SELECT COT(1)",(new Select())->select(Math::cot($one))->toSql($this->conn));
        $this->assertSimilar("SELECT CRC32('MySQL')",(new Select())->select(Math::crc32(new Value('MySQL')))->toSql($this->conn));
        $this->assertSimilar("SELECT DEGREES(1)",(new Select())->select(Math::degrees($one))->toSql($this->conn));
        $this->assertSimilar("SELECT EXP(1)",(new Select())->select(Math::exp($one))->toSql($this->conn));
        $this->assertSimilar("SELECT FLOOR(1)",(new Select())->select(Math::floor($one))->toSql($this->conn));
        $this->assertSimilar("SELECT FORMAT(12332.123456, 4)",(new Select())->select(Math::format(new Value(12332.123456),new Value(4)))->toSql($this->conn));
        $this->assertSimilar("SELECT FORMAT(12332.2,2,'de_DE')",(new Select())->select(Math::format(new Value(12332.2),new Value(2), new Value('de_DE')))->toSql($this->conn));
        $this->assertSimilar("SELECT FORMAT(12332.2,2,'de_DE')",(new Select())->select(Math::format(new Value(12332.2),new Value(2), new Value('de_DE')))->toSql($this->conn));
        $hexAbc = Math::hex(new Value('abc'));
        $this->assertSimilar("SELECT 0x616263, 0x616263, HEX('abc'), UNHEX(HEX('abc'))",(new Select())->select(
            new HexLiteral(0x616263), new HexLiteral('abc'), $hexAbc, Str::unhex($hexAbc)
        )->toSql($this->conn));
        $this->assertSimilar("SELECT LN(2)",(new Select())->select(Math::ln($two))->toSql($this->conn));
        $this->assertSimilar("SELECT LOG(2)",(new Select())->select(Math::log($two))->toSql($this->conn));
        $this->assertSimilar("SELECT LOG(2, 1)",(new Select())->select(Math::log($two, $one))->toSql($this->conn));
        $this->assertSimilar("SELECT LOG2(2)",(new Select())->select(Math::log2($two))->toSql($this->conn));
        $this->assertSimilar("SELECT LOG10(2)",(new Select())->select(Math::log10($two))->toSql($this->conn));
        $this->assertSimilar("SELECT MOD(234, 10)",(new Select())->select(Math::mod(new Value(234), new Value(10)))->toSql($this->conn));
        $this->assertSimilar("SELECT MOD(29, 9)",(new Select())->select(Math::mod(new Value(29), new Value(9)))->toSql($this->conn));
        $this->assertSimilar("SELECT MOD(34.5, 3)",(new Select())->select(Math::mod(new Value(34.5), new Value(3)))->toSql($this->conn));
        $this->assertSimilar("SELECT PI()",(new Select())->select(Math::pi())->toSql($this->conn));
        $this->assertSimilar("SELECT POW(2, 2)",(new Select())->select(Math::pow($two, $two))->toSql($this->conn));
        $this->assertSimilar("SELECT RADIANS(90)",(new Select())->select(Math::radians(new Value(90)))->toSql($this->conn));
        $this->assertSimilar("SELECT RAND(), RAND(3)",(new Select())->select(Math::rand(), Math::rand(new Value(3)))->toSql($this->conn));
        $this->assertSimilar("SELECT FLOOR(7 + RAND() * (12 - 7))",(new Select())->select(Math::randInt(new Value(7), new Value(12)))->toSql($this->conn));
        $this->assertSimilar("SELECT FLOOR(7 + RAND(3) * (12 - 7))",(new Select())->select(Math::randInt(new Value(7), new Value(12), new Value(3)))->toSql($this->conn));
        $this->assertSimilar("SELECT ROUND(-1.23)",(new Select())->select(Math::round(new Value(-1.23)))->toSql($this->conn));
        $this->assertSimilar("SELECT ROUND(1.298, 1)",(new Select())->select(Math::round(new Value(1.298), new Value(1)))->toSql($this->conn));
        $this->assertSimilar("SELECT SIGN(2.5)",(new Select())->select(Math::sign(new Value(2.5)))->toSql($this->conn));
        $this->assertSimilar("SELECT SIN(PI())",(new Select())->select(Math::sin(Math::pi()))->toSql($this->conn));
        $this->assertSimilar("SELECT SQRT(4)",(new Select())->select(Math::sqrt(new Value(4)))->toSql($this->conn));
        $this->assertSimilar("SELECT TAN(PI())",(new Select())->select(Math::tan(Math::pi()))->toSql($this->conn));
        $this->assertSimilar("SELECT TRUNCATE(1.223,1)",(new Select())->select(Math::truncate(new Value(1.223), new Value(1)))->toSql($this->conn));
    }

    function testStringFuncs() {
        $this->assertSimilar("SELECT CHAR(77,121,83,81,'76')",(new Select())->select(Str::char(new Value(77), new Value(121), new Value(83), new Value(81), new Value('76')))->toSql($this->conn));
        $this->assertSimilar("SELECT CHAR(0x65 USING utf8)",(new Select())->select(Str::charUsing(Charset::utf8(), new HexLiteral(101)))->toSql($this->conn));
        $this->assertSimilar("SELECT CHAR_LENGTH('Hello world')",(new Select())->select(Str::charLength(new Value('Hello world')))->toSql($this->conn));
        $this->assertSimilar("SELECT CONCAT_WS(',','First name','Second name','Last Name')",(new Select())->select(Str::concatWS(new Value(','),new Value('First name'),new Value('Second name'),new Value('Last name')))->toSql($this->conn));
        $this->assertSimilar("SELECT EXPORT_SET(5,'Y','N',',',4)",(new Select())->select(Str::exportSet(new Value(5), new Value('Y'), new Value('N'), new Value(','), new Value(4)))->toSql($this->conn));
        $this->assertSimilar("SELECT FIELD('ej', 'Hej', 'ej', 'Heja', 'hej', 'foo')",(new Select())->select(Str::field(new Value('ej'),new Value('Hej'),new Value('ej'),new Value('Heja'),new Value('hej'),new Value('foo')))->toSql($this->conn));
        $this->assertSimilar("SELECT MAKE_SET(1 | 4,'hello','nice','world')",(new Select())->select(
            Str::makeSet(new BitOr(new Value(1), new Value(4)), new Value('hello'), new Value('nice'), new Value('world'))
        )->toSql($this->conn));

        $this->assertSimilar("SELECT TRIM('  bar   ')",Stmt::select()->select(Str::trim(new Value('  bar   ')))->toSql($this->conn));
        $this->assertSimilar("SELECT TRIM(LEADING 'x' FROM 'xxxbarxxx')",Stmt::select()->select(Str::trimLeading(new Value('xxxbarxxx'),new Value('x')))->toSql($this->conn));
        $this->assertSimilar("SELECT TRIM(BOTH 'x' FROM 'xxxbarxxx')",Stmt::select()->select(Str::trim(new Value('xxxbarxxx'),new Value('x')))->toSql($this->conn));
        $this->assertSimilar("SELECT TRIM(TRAILING 'xyz' FROM 'barxxyz')",Stmt::select()->select(Str::trimTrailing(new Value('barxxyz'),new Value('xyz')))->toSql($this->conn));

        $this->assertSimilar("SELECT WEIGHT_STRING(@s)",Stmt::select()->select(Str::weightString(new UserVariable('s')))->toSql($this->conn));
        $this->assertSimilar("SELECT WEIGHT_STRING('ab' AS CHAR(4))",Stmt::select()->select(Str::weightString(new StringLiteral('ab'), 'CHAR(4)'))->toSql($this->conn));
        $this->assertSimilar("SELECT WEIGHT_STRING(0x7FFF LEVEL 1 DESC REVERSE)",Stmt::select()->select(Str::weightString(new HexLiteral(0x7FFF), null, '1 DESC REVERSE'))->toSql($this->conn));
        $this->assertSimilar("SELECT WEIGHT_STRING('xy' AS BINARY(8) LEVEL 1-3)",Stmt::select()->select(Str::weightString(new StringLiteral('xy'), 'BINARY(8)', '1-3'))->toSql($this->conn));
        $this->assertSimilar("SELECT WEIGHT_STRING('x' LEVEL 2, 3, 5)",Stmt::select()->select(Str::weightString(new StringLiteral('x'), null, [2,3,5]))->toSql($this->conn));
        $this->assertSimilar("SELECT WEIGHT_STRING('x' LEVEL 1 ASC, 2 DESC, 3 REVERSE)",Stmt::select()->select(Str::weightString(new StringLiteral('x'), null, ['1 ASC', '2 DESC', '3 REVERSE']))->toSql($this->conn));

        $this->assertSimilar("SELECT CONCAT('My', 'S', 'QL')",Stmt::select()->select(Str::concat(new StringLiteral('My'),new StringLiteral('S'),new StringLiteral('QL')))->toSql($this->conn));
        $this->assertSimilar("SELECT CONCAT('My', NULL, 'QL')",Stmt::select()->select(Str::concat(new StringLiteral('My'),new Value(null),new StringLiteral('QL')))->toSql($this->conn));
        $this->assertSimilar("SELECT CONCAT(14.3)",Stmt::select()->select(Str::concat(new Value(14.3)))->toSql($this->conn));
    }

    function testStringLiteral() {
        // see https://dev.mysql.com/doc/refman/5.7/en/string-literals.html
        $this->assertEquals("SELECT 'string'", (new Select())->select(new StringLiteral('string'))->toSql($this->conn));
        $this->assertEquals("SELECT _latin1'string'", (new Select())->select(new StringLiteral('string', Charset::latin1()))->toSql($this->conn));
        $this->assertEquals("SELECT _latin1'string' COLLATE latin1_danish_ci", (new Select())->select(new StringLiteral('string', Charset::latin1(), Collation::latin1_danish_ci()))->toSql($this->conn));
    }

    function testAggregateFuncs() {
        $select = Stmt::select()
            ->select(Agg::exists(Stmt::select()
                ->from(new Dual)
                ->select(new Asterisk)
                ->where(new Value(0)))
            );
        $this->assertSimilar("SELECT EXISTS(SELECT * FROM DUAL WHERE 0)",$select->toSql($this->conn));
        $this->assertSimilar("SELECT SUM(`amount`)",Stmt::select()->select(Agg::sum(new Column('amount')))->toSql($this->conn));
        $this->assertSimilar("SELECT SUM(DISTINCT `amount`)",Stmt::select()->select(Agg::sum(new Column('amount'),true))->toSql($this->conn));
        $this->assertSimilar("SELECT COUNT(*)",Stmt::select()->select(Agg::countRows())->toSql($this->conn));
        $this->assertSimilar("SELECT COUNT(`name`)",Stmt::select()->select(Agg::countNonNull(new Column('name')))->toSql($this->conn));
        $this->assertSimilar("SELECT COUNT(DISTINCT `first_name`, `last_name`)",Stmt::select()->select(Agg::countDistinct(new Column('first_name'),new Column('last_name')))->toSql($this->conn));

        $this->assertSimilar("
            SELECT `student_name`,
                GROUP_CONCAT(DISTINCT `test_score` ORDER BY `test_score` DESC SEPARATOR ' ')
                FROM `student`
                GROUP BY `student_name`
                ",
            Stmt::select()
                ->select(
                    new Column('student_name'),
                    Agg::groupConcat([new Column('test_score')],true,[new Order(new Column('test_score'),Order::DESC)],' ')
                )
                ->from(new Table('student'))
                ->groupBy(new Column('student_name'))
                ->toSql($this->conn));
    }

    function testHex() {
        // https://dev.mysql.com/doc/refman/5.7/en/hexadecimal-literals.html
        $this->assertSimilar("SELECT 0x0a",Stmt::select()->select(new HexLiteral("0x0a",true))->toSql($this->conn));
        $this->assertSimilar("SELECT 0xaaa",Stmt::select()->select(new HexLiteral("0xaaa",true))->toSql($this->conn));
        $this->assertSimilar("SELECT X'4D7953514C'",Stmt::select()->select(new HexLiteral("X'4D7953514C'",true))->toSql($this->conn));
        $this->assertSimilar("SELECT 0x5061756c",Stmt::select()->select(new HexLiteral("0x5061756c",true))->toSql($this->conn));
        $this->assertSimilar("SELECT 0xacbd18db4cc2f85cedef654fccc4a4d8",Stmt::select()->select(new HexLiteral(md5('foo'),true))->toSql($this->conn));
        $this->assertSimilar("SELECT 0xACBD18DB4CC2F85CEDEF654FCCC4A4D8",Stmt::select()->select(new HexLiteral(md5('foo',true),false))->toSql($this->conn));
        $this->assertSimilar("SELECT 0xA",Stmt::select()->select(new HexLiteral(10))->toSql($this->conn));
    }

    function testHexEx() {
        $this->setExpectedException(\Exception::class);
        new HexLiteral("X'4D7953514'",true); // For values written using X'val' or x'val' format, val must contain an even number of digits.
    }

    function testTimeFuncs() {
        $this->assertSimilar("SELECT CONVERT_TZ(DATE_ADD('1970-01-01', INTERVAL 567082800 SECOND),'UTC',@@session.time_zone)",Stmt::select()->select(\QueryBuilder\MySql\Functions\Time::unixToDateTime(new Value(567082800)))->toSql($this->conn));
    }

    function testSuperQualified() {
        $tbl = new Table('tbl',new Database('db'));
        $this->assertSimilar("SELECT `db`.`tbl`.`col` FROM `db`.`tbl`",(new Select())->select($tbl->column('col'))->from($tbl)->toSql($this->conn));
    }

    function testSelectExpr() {
        $this->assertSimilar("SELECT 1",(new Select())->select(new Value(1))->toSql($this->conn));
        $this->assertSimilar("SELECT 1 + 2",(new Select())->select(new Add(new Value(1),new Value(2)))->toSql($this->conn));
    }

    function testDeathDate() {
$sql = <<<'SQL'
SELECT 
    `emr_client_id` AS `0`, 
    `ecl_first_name` AS `1`, 
    `ecl_middle_name` AS `2`,
    `ecl_last_name` AS `3`, 
    `ecl_birth_date` AS `4`, 
    (
        SELECT min(`ecp_discharge_date`) 
        FROM (
                SELECT `ecp_discharge_date`, `ecp_client_id` 
                FROM `wx_clk_io`.`emr_client_program` 
                    INNER JOIN `wx_clk_io`.`emr_discharge_reason` ON `emr_discharge_reason_id` = `ecp_discharge_reason_id` 
                WHERE `dch_name` LIKE '%deceased%' OR `dch_name` LIKE '%death%'
            UNION ALL 
                SELECT `ecp_discharge_date`, `ecp_client_id` 
                FROM `wx_clk_fs`.`emr_client_program` 
                    INNER JOIN `wx_clk_fs`.`emr_discharge_reason` ON `emr_discharge_reason_id` = `ecp_discharge_reason_id` 
                WHERE `dch_name` LIKE '%deceased%' OR `dch_name` LIKE '%death%' 
            UNION ALL 
                SELECT `ecp_discharge_date`, `ecp_client_id` 
                FROM `wx_clk_com`.`emr_client_program` 
                    INNER JOIN `wx_clk_com`.`emr_discharge_reason` ON `emr_discharge_reason_id` = `ecp_discharge_reason_id` 
                WHERE `dch_name` LIKE '%deceased%' OR `dch_name` LIKE '%death%'
            UNION ALL 
                SELECT `ecp_discharge_date`, `ecp_client_id` 
                FROM `wx_clk_sil`.`emr_client_program` 
                    INNER JOIN `wx_clk_sil`.`emr_discharge_reason` ON `emr_discharge_reason_id` = `ecp_discharge_reason_id` 
                WHERE `dch_name` LIKE '%deceased%' OR `dch_name` LIKE '%death%' 
            UNION ALL 
                SELECT `ecp_discharge_date`, `ecp_client_id` 
                FROM `wx_clk_opt`.`emr_client_program` 
                    INNER JOIN `wx_clk_opt`.`emr_discharge_reason` ON `emr_discharge_reason_id` = `ecp_discharge_reason_id` 
                WHERE `dch_name` LIKE '%deceased%' OR `dch_name` LIKE '%death%' 
            UNION ALL 
                SELECT `ecp_discharge_date`, `ecp_client_id` 
                FROM `wx_clk_res`.`emr_client_program` 
                    INNER JOIN `wx_clk_res`.`emr_discharge_reason` ON `emr_discharge_reason_id` = `ecp_discharge_reason_id` 
                WHERE `dch_name` LIKE '%deceased%' OR `dch_name` LIKE '%death%'
            UNION ALL 
                SELECT `ecp_discharge_date`, `ecp_client_id` 
                FROM `wx_clk_ccr`.`emr_client_program` 
                    INNER JOIN `wx_clk_ccr`.`emr_discharge_reason` ON `emr_discharge_reason_id` = `ecp_discharge_reason_id` 
                WHERE `dch_name` LIKE '%deceased%' OR `dch_name` LIKE '%death%'
            UNION ALL SELECT `ecp_discharge_date`, `ecp_client_id`
                FROM `wx_clk_gan`.`emr_client_program` 
                    INNER JOIN `wx_clk_gan`.`emr_discharge_reason` ON `emr_discharge_reason_id` = `ecp_discharge_reason_id` 
                WHERE `dch_name` LIKE '%deceased%' OR `dch_name` LIKE '%death%'
            UNION ALL 
                SELECT `ecp_discharge_date`, `ecp_client_id` 
                FROM `wx_clk_sen`.`emr_client_program` 
                    INNER JOIN `wx_clk_sen`.`emr_discharge_reason` ON `emr_discharge_reason_id` = `ecp_discharge_reason_id` 
                WHERE `dch_name` LIKE '%deceased%' OR `dch_name` LIKE '%death%'
            UNION ALL 
                SELECT `ecp_discharge_date`, `ecp_client_id` 
                FROM `wx_clk_co2`.`emr_client_program` 
                    INNER JOIN `wx_clk_co2`.`emr_discharge_reason` ON `emr_discharge_reason_id` = `ecp_discharge_reason_id` 
                WHERE `dch_name` LIKE '%deceased%' OR `dch_name` LIKE '%death%'
        ) AS `dischargeReasonDeceased` 
        WHERE `ecp_client_id` = `emr_client_id`
    ) AS `5` 
FROM `wx_clk_pcs`.`emr_client` 
LIMIT 5
SQL;

        $union = new UnionAll();
        $dbNames = ['wx_clk_io','wx_clk_fs','wx_clk_com','wx_clk_sil','wx_clk_opt','wx_clk_res','wx_clk_ccr','wx_clk_gan','wx_clk_sen','wx_clk_co2'];
        foreach ($dbNames as $dbName) {
            $db = new Database($dbName);
            $union->push(
                (new Select())
                    ->select(new Column('ecp_discharge_date'), new Column('ecp_client_id'))->from($db->table('emr_client_program'))
                    ->innerJoin($db->table('emr_discharge_reason'),new Equal(new Column('emr_discharge_reason_id'),new Column('ecp_discharge_reason_id')))
                    ->where(new LogOr(new \QueryBuilder\Operator\Like(new Column('dch_name'), new Value('%deceased%')),new \QueryBuilder\Operator\Like(new Column('dch_name'), new Value('%death%'))))
            );
        }
        $minDischargeDate = (new Select())
            ->select(Agg::min(new Column('ecp_discharge_date')))
            ->from(new SelectTable($union,new TableAlias('dischargeReasonDeceased')))
            ->where(new Equal(new Column('ecp_client_id'),new Column('emr_client_id')))
            ;

        $this->assertSimilar($sql,
            (new Select())
            ->from(new Table('emr_client',new Database('wx_clk_pcs')))
                ->select(new ExprAs(new Column('emr_client_id'),new FieldAlias('0')))
                ->select(new ExprAs(new Column('ecl_first_name'),new FieldAlias('1')))
                ->select(new ExprAs(new Column('ecl_middle_name'),new FieldAlias('2')))
                ->select(new ExprAs(new Column('ecl_last_name'),new FieldAlias('3')))
                ->select(new ExprAs(new Column('ecl_birth_date'),new FieldAlias('4')))
                ->select(new ExprAs(new \QueryBuilder\SelectExpr($minDischargeDate),new FieldAlias('5')))
                ->limit(5)
            ->toSql($this->conn)
        );
    }

    function testStatsQuery() {
$sql = <<<'SQL'
SELECT
    `ecl_file_no` AS `File No`,
    `ecl_last_name` AS `Last Name`,
    `ecl_first_name` AS `First Name`,
    `epg_short_name` AS `Program`,
    `ed_short_name` AS `Discipline`,
    (
        SELECT sum(`siv_value`) FROM `emr_stats_report`
            LEFT JOIN `emr_stats_item` ON `sli_stats_report_id` = `emr_stats_report_id`
            LEFT JOIN `emr_stats_item_value` ON `siv_stats_item_id` = `emr_stats_item_id`
            LEFT JOIN `emr_stats_field` ON `siv_stats_field_id` = `emr_stats_field_id`
        WHERE `sli_client_id` = `emr_client_id` AND `esr_date` BETWEEN 1420099200 AND 1451635200 AND `esr_discipline_id` = `emr_discipline_id` AND `esf_short_name2` = 'AS'
    ) AS `AS Time`,
    (
        SELECT sum(`siv_value`) FROM `emr_stats_report`
            LEFT JOIN `emr_stats_item` ON `sli_stats_report_id` = `emr_stats_report_id`
            LEFT JOIN `emr_stats_item_value` ON `siv_stats_item_id` = `emr_stats_item_id`
            LEFT JOIN `emr_stats_field` ON `siv_stats_field_id` = `emr_stats_field_id`
        WHERE `sli_client_id` = `emr_client_id` AND `esr_date` BETWEEN 1420099200 AND 1451635200 AND `esr_discipline_id` = `emr_discipline_id` AND `esf_short_name2` = 'IC'
    ) AS `IC Time`,
    (
        SELECT sum(`siv_value`) FROM `emr_stats_report`
            LEFT JOIN `emr_stats_item` ON `sli_stats_report_id` = `emr_stats_report_id`
            LEFT JOIN `emr_stats_item_value` ON `siv_stats_item_id` = `emr_stats_item_id`
            LEFT JOIN `emr_stats_field` ON `siv_stats_field_id` = `emr_stats_field_id`
        WHERE `sli_client_id` = `emr_client_id` AND `esr_date` BETWEEN 1420099200 AND 1451635200 AND `esr_discipline_id` = `emr_discipline_id` AND `esf_short_name2` = 'INTV'
    ) AS `INTV Time`,
    (SELECT sum(`intv_time`.`gsv_value`) FROM `emr_group_stats_report`
        LEFT JOIN `emr_group_stats_value` AS `attendance` ON `attendance`.`gsv_group_stats_report_id` = `emr_group_stats_report_id` AND `attendance`.`gsv_group_stats_field_id` = 10
        LEFT JOIN `emr_group_stats_value` AS `intv_time` ON `intv_time`.`gsv_group_stats_report_id` = `emr_group_stats_report_id` AND `intv_time`.`gsv_group_stats_field_id` = 4
        LEFT JOIN `emr_group_stats_field` ON `intv_time`.`gsv_group_stats_field_id` = `emr_group_stats_field_id`
    WHERE `attendance`.`gsv_client_id` = `emr_client_id` AND `gsr_date` BETWEEN 1420099200 AND 1451635200
    ) AS `GRP INTV`,
    `ecl_diagnosis2` AS `Specific Diag`,
    `pn1`.`epn_name` AS `Presenting Needs`,
    `pn2`.`epn_name` AS `Sec. Presenting Needs`
FROM `emr_client`
    LEFT JOIN `emr_client_program` on `ecp_client_id` = `emr_client_id`
    LEFT JOIN `emr_clinician_program` ON `clp_client_program_id` = `emr_client_program_id`
    LEFT JOIN `emr_program` ON `ecp_program_id` = `emr_program_id`
    LEFT JOIN `emr_discipline` ON `clp_discipline_id` = `emr_discipline_id`
    LEFT JOIN `emr_presenting_needs` AS `pn1` ON `pn1`.`emr_presenting_needs_id` = `ecl_presenting_needs`
    LEFT JOIN `emr_presenting_needs` AS `pn2` ON `pn2`.`emr_presenting_needs_id` = `ecl_presenting_needs2`
WHERE
    `epg_short_name` = 'EIP' AND
        `ed_short_name` = 'PT' AND
        (
            `ecl_diagnosis2` = 'Torticollis' OR
                `ecl_diagnosis2` = 'Plagiocephaly' OR
                `pn1`.`epn_name` = 'Torticollis - Suspected' OR
                `pn1`.`epn_name` = 'Plagiocephaly - Suspected' OR
                `pn2`.`epn_name` = 'Torticollis - Suspected' OR
                `pn2`.`epn_name` = 'Plagiocephaly - Suspected'
        )
GROUP BY `emr_client_id`
HAVING `AS Time` > 0 OR `IC Time` > 0 OR `INTV Time` > 0
ORDER BY `ecl_last_name`
SQL;


        $pn1 = new TableAlias('pn1');
        $pn2 = new TableAlias('pn2');

        $valueQuery = (new Select())->select(Agg::sum(new Column('siv_value')))
            ->from(new Table('emr_stats_report'))
            ->leftJoin(new Table('emr_stats_item'),new Equal(new Column('sli_stats_report_id'),new Column('emr_stats_report_id')))
            ->leftJoin(new Table('emr_stats_item_value'),new Equal(new Column('siv_stats_item_id'),new Column('emr_stats_item_id')))
            ->leftJoin(new Table('emr_stats_field'),new Equal(new Column('siv_stats_field_id'),new Column('emr_stats_field_id')))
            ;

        $startDate = new Value(1420099200);
        $endDate = new Value(1451635200);
        $valueWhere = new LogAnd(new Equal(new Column('sli_client_id'),new Column('emr_client_id')),new Between(new Column('esr_date'), $startDate, $endDate),new Equal(new Column('esr_discipline_id'),new Column('emr_discipline_id')));

        $asTimeField = new FieldAlias('AS Time');
        $icTimeField = new FieldAlias('IC Time');
        $intvTimeField = new FieldAlias('INTV Time');
        $query = (new Select())
            ->from(new Table('emr_client'))
            ->leftJoin(new Table('emr_client_program'), new Equal(new Column('ecp_client_id'), new Column('emr_client_id')))
            ->leftJoin(new Table('emr_clinician_program'), new Equal(new Column('clp_client_program_id'), new Column('emr_client_program_id')))
            ->leftJoin(new Table('emr_program'), new Equal(new Column('ecp_program_id'), new Column('emr_program_id')))
            ->leftJoin(new Table('emr_discipline'), new Equal(new Column('clp_discipline_id'), new Column('emr_discipline_id')))
            ->leftJoin(new TableAs(new Table('emr_presenting_needs'), $pn1), new Equal($pn1->column('emr_presenting_needs_id'), new Column('ecl_presenting_needs')))
            ->leftJoin(new TableAs(new Table('emr_presenting_needs'), $pn2), new Equal($pn2->column('emr_presenting_needs_id'), new Column('ecl_presenting_needs2')))
            ->select(new ExprAs(new Column('ecl_file_no'), new FieldAlias('File No')))
            ->select(new ExprAs(new Column('ecl_last_name'), new FieldAlias('Last Name')))
            ->select(new ExprAs(new Column('ecl_first_name'), new FieldAlias('First Name')))
            ->select(new ExprAs(new Column('epg_short_name'), new FieldAlias('Program')))
            ->select(new ExprAs(new Column('ed_short_name'), new FieldAlias('Discipline')))
            ->select(new ExprAs(new \QueryBuilder\SelectExpr($valueQuery->copy()->where($valueWhere->copy()->push(new Equal(new Column('esf_short_name2'), new Value('AS'))))), $asTimeField))
            ->select(new ExprAs(new \QueryBuilder\SelectExpr($valueQuery->copy()->where($valueWhere->copy()->push(new Equal(new Column('esf_short_name2'), new Value('IC'))))), $icTimeField))
            ->select(new ExprAs(new \QueryBuilder\SelectExpr($valueQuery->copy()->where($valueWhere->copy()->push(new Equal(new Column('esf_short_name2'), new Value('INTV'))))), $intvTimeField));

        $attendance = new TableAlias('attendance');
        $intv_time = new TableAlias('intv_time');
        $sumGroupStatValues = (new Select())->from(new Table('emr_group_stats_report'))
            ->leftJoin(new TableAs(new Table('emr_group_stats_value'), $attendance),new LogAnd(new Equal($attendance->column('gsv_group_stats_report_id'), new Column('emr_group_stats_report_id')),new Equal($attendance->column('gsv_group_stats_field_id'), new Value(10))))
            ->leftJoin(new TableAs(new Table('emr_group_stats_value'), $intv_time),new LogAnd(new Equal($intv_time->column('gsv_group_stats_report_id'), new Column('emr_group_stats_report_id')),new Equal($intv_time->column('gsv_group_stats_field_id'), new Value(4))))
            ->leftJoin(new Table('emr_group_stats_field'),new Equal($intv_time->column('gsv_group_stats_field_id'),new Column('emr_group_stats_field_id')))
            ->select(Agg::sum($intv_time->column('gsv_value')))
            ->where(new LogAnd(new Equal($attendance->column('gsv_client_id'),new Column('emr_client_id')),new Between(new Column('gsr_date'), $startDate, $endDate)))
        ;

        $query->select(new ExprAs(new \QueryBuilder\SelectExpr($sumGroupStatValues),new FieldAlias('GRP INTV')))
            ->select(new ExprAs(new Column('ecl_diagnosis2'),new FieldAlias('Specific Diag')))
            ->select(new ExprAs($pn1->column('epn_name'),new FieldAlias('Presenting Needs')))
            ->select(new ExprAs($pn2->column('epn_name'),new FieldAlias('Sec. Presenting Needs')))
            ->where(new LogAnd(
                new Equal(new Column('epg_short_name'),new Value('EIP')),
                new Equal(new Column('ed_short_name'),new Value('PT')),
                new LogOr(
                    new Equal(new Column('ecl_diagnosis2'),new Value('Torticollis')),
                    new Equal(new Column('ecl_diagnosis2'),new Value('Plagiocephaly')),
                    new Equal($pn1->column('epn_name'),new Value('Torticollis - Suspected')),
                    new Equal($pn1->column('epn_name'),new Value('Plagiocephaly - Suspected')),
                    new Equal($pn2->column('epn_name'),new Value('Torticollis - Suspected')),
                    new Equal($pn2->column('epn_name'),new Value('Plagiocephaly - Suspected'))
                )
            ))
            ->groupBy(new Column('emr_client_id'))
            ->having(new LogOr(
                new GreaterThan($asTimeField,new Value(0)),
                new GreaterThan($icTimeField,new Value(0)),
                new GreaterThan($intvTimeField,new Value(0))
            ))
            ->orderBy(new Column('ecl_last_name'))
        ;

        $this->assertSimilar($sql, $query->toSql($this->conn));
    }

    function testJasonQuery() {
        $sql = <<<'SQL'
SELECT `ecl_file_no` AS `File Number`,
`ecl_name` AS `Persons Name`,
ts2d(`ecl_birth_date`) AS `DOB`,
`ecl_gender` AS `Gender`,
(SELECT GROUP_CONCAT(DISTINCT `epg_name`) FROM (
    SELECT `epg_name`, `ecp_client_id` FROM `wx_clk_ccr`.`emr_client_program` LEFT JOIN `emr_program` ON `ecp_program_id`=`emr_program_id` 
    UNION ALL
    SELECT `epg_name`, `ecp_client_id` FROM `wx_clk_co2`.`emr_client_program` LEFT JOIN `emr_program` ON `ecp_program_id`=`emr_program_id` 
    UNION ALL
    SELECT `epg_name`, `ecp_client_id` FROM `wx_clk_com`.`emr_client_program` LEFT JOIN `emr_program` ON `ecp_program_id`=`emr_program_id` 
    UNION ALL
    SELECT `epg_name`, `ecp_client_id` FROM `wx_clk_fs`.`emr_client_program` LEFT JOIN `emr_program` ON `ecp_program_id`=`emr_program_id` 
    UNION ALL
    SELECT `epg_name`, `ecp_client_id` FROM `wx_clk_gan`.`emr_client_program` LEFT JOIN `emr_program` ON `ecp_program_id`=`emr_program_id` 
    UNION ALL
    SELECT `epg_name`, `ecp_client_id` FROM `wx_clk_io`.`emr_client_program` LEFT JOIN `emr_program` ON `ecp_program_id`=`emr_program_id` 
    UNION ALL
    SELECT `epg_name`, `ecp_client_id` FROM `wx_clk_opt`.`emr_client_program` LEFT JOIN `emr_program` ON `ecp_program_id`=`emr_program_id` 
    UNION ALL
    SELECT `epg_name`, `ecp_client_id` FROM `wx_clk_res`.`emr_client_program` LEFT JOIN `emr_program` ON `ecp_program_id`=`emr_program_id` 
    UNION ALL
    SELECT `epg_name`, `ecp_client_id` FROM `wx_clk_sen`.`emr_client_program` LEFT JOIN `emr_program` ON `ecp_program_id`=`emr_program_id` 
    UNION ALL
    SELECT `epg_name`, `ecp_client_id` FROM `wx_clk_sil`.`emr_client_program` LEFT JOIN `emr_program` ON `ecp_program_id`=`emr_program_id` 
) AS `temporary_name_we_dont_care_about_program` WHERE `ecp_client_id`=`emr_client_id` ) AS `Programs`,
(SELECT GROUP_CONCAT(DISTINCT ELT(`pgi_family`,'High Level','Limited','Moderate','None')) FROM (
    SELECT `pgi_family`, `pgi_client_id` FROM `wx_clk_ccr`.`prof_general_info`
    UNION ALL
    SELECT `pgi_family`, `pgi_client_id` FROM `wx_clk_co2`.`prof_general_info`
    UNION ALL
    SELECT `pgi_family`, `pgi_client_id` FROM `wx_clk_com`.`prof_general_info`
    UNION ALL
    SELECT `pgi_family`, `pgi_client_id` FROM `wx_clk_fs`.`prof_general_info`
    UNION ALL
    SELECT `pgi_family`, `pgi_client_id` FROM `wx_clk_gan`.`prof_general_info`
    UNION ALL
    SELECT `pgi_family`, `pgi_client_id` FROM `wx_clk_io`.`prof_general_info` 
    UNION ALL
    SELECT `pgi_family`, `pgi_client_id` FROM `wx_clk_opt`.`prof_general_info`
    UNION ALL
    SELECT `pgi_family`, `pgi_client_id` FROM `wx_clk_res`.`prof_general_info`
    UNION ALL
    SELECT `pgi_family`, `pgi_client_id` FROM `wx_clk_sen`.`prof_general_info`
    UNION ALL
    SELECT `pgi_family`, `pgi_client_id` FROM `wx_clk_sil`.`prof_general_info`
) AS `temporary_name_we_dont_care_about_family_inv` WHERE `pgi_client_id`=`emr_client_id` ) AS `Family Involvement`,
(SELECT GROUP_CONCAT(DISTINCT ELT(`pgi_friend`,'High Level','Limited','Moderate','None')) FROM (
    SELECT `pgi_friend`, `pgi_client_id` FROM `wx_clk_ccr`.`prof_general_info`
    UNION ALL
    SELECT `pgi_friend`, `pgi_client_id` FROM `wx_clk_co2`.`prof_general_info`
    UNION ALL
    SELECT `pgi_friend`, `pgi_client_id` FROM `wx_clk_com`.`prof_general_info`
    UNION ALL
    SELECT `pgi_friend`, `pgi_client_id` FROM `wx_clk_fs`.`prof_general_info`
    UNION ALL
    SELECT `pgi_friend`, `pgi_client_id` FROM `wx_clk_gan`.`prof_general_info`
    UNION ALL
    SELECT `pgi_friend`, `pgi_client_id` FROM `wx_clk_io`.`prof_general_info` 
    UNION ALL
    SELECT `pgi_friend`, `pgi_client_id` FROM `wx_clk_opt`.`prof_general_info`
    UNION ALL
    SELECT `pgi_friend`, `pgi_client_id` FROM `wx_clk_res`.`prof_general_info`
    UNION ALL
    SELECT `pgi_friend`, `pgi_client_id` FROM `wx_clk_sen`.`prof_general_info`
    UNION ALL
    SELECT `pgi_friend`, `pgi_client_id` FROM `wx_clk_sil`.`prof_general_info`
) AS `temporary_name_we_dont_care_about_friend_inv` WHERE `pgi_client_id`=`emr_client_id` ) AS `Friend Involvement`,
(SELECT GROUP_CONCAT(DISTINCT ELT(`pgi_mobility`,'Assisted Wheelchair','Self Propelled Wheelchair','Walker / Cane','Walks Assisted','Walks Independently','Pre-Walking')) FROM (
    SELECT `pgi_mobility`, `pgi_client_id` FROM `wx_clk_ccr`.`prof_general_info`
    UNION ALL
    SELECT `pgi_mobility`, `pgi_client_id` FROM `wx_clk_co2`.`prof_general_info`
    UNION ALL
    SELECT `pgi_mobility`, `pgi_client_id` FROM `wx_clk_com`.`prof_general_info`
    UNION ALL
    SELECT `pgi_mobility`, `pgi_client_id` FROM `wx_clk_fs`.`prof_general_info`
    UNION ALL
    SELECT `pgi_mobility`, `pgi_client_id` FROM `wx_clk_gan`.`prof_general_info`
    UNION ALL
    SELECT `pgi_mobility`, `pgi_client_id` FROM `wx_clk_io`.`prof_general_info` 
    UNION ALL
    SELECT `pgi_mobility`, `pgi_client_id` FROM `wx_clk_opt`.`prof_general_info`
    UNION ALL
    SELECT `pgi_mobility`, `pgi_client_id` FROM `wx_clk_res`.`prof_general_info`
    UNION ALL
    SELECT `pgi_mobility`, `pgi_client_id` FROM `wx_clk_sen`.`prof_general_info`
    UNION ALL
    SELECT `pgi_mobility`, `pgi_client_id` FROM `wx_clk_sil`.`prof_general_info`
) AS `temporary_name_we_dont_care_about_mobility` WHERE `pgi_client_id`=`emr_client_id` ) AS `Mobility`,
(SELECT GROUP_CONCAT(DISTINCT ELT(`pgi_religion`,'Anglican','Catholic','Jewish','Jehovah\'s Witness','Muslim','Protestant','Roman Catholic','Sikh','United','Atheist','Agnostic','Non-Religion','Christian','Other','Presbyterian','Baptist','Greek Orthodox','Lutheran','Methodist','Mormon','New Episcopal','Pentecostal','Salvation Army','Seventh Day Adventist','Evangelist','Brethren','Buddhist','Islam','Mennonite','New Apostolic','Orthodox')) FROM (
    SELECT `pgi_religion`, `pgi_client_id` FROM `wx_clk_ccr`.`prof_general_info`
    UNION ALL
    SELECT `pgi_religion`, `pgi_client_id` FROM `wx_clk_co2`.`prof_general_info`
    UNION ALL
    SELECT `pgi_religion`, `pgi_client_id` FROM `wx_clk_com`.`prof_general_info`
    UNION ALL
    SELECT `pgi_religion`, `pgi_client_id` FROM `wx_clk_fs`.`prof_general_info`
    UNION ALL
    SELECT `pgi_religion`, `pgi_client_id` FROM `wx_clk_gan`.`prof_general_info`
    UNION ALL
    SELECT `pgi_religion`, `pgi_client_id` FROM `wx_clk_io`.`prof_general_info` 
    UNION ALL
    SELECT `pgi_religion`, `pgi_client_id` FROM `wx_clk_opt`.`prof_general_info`
    UNION ALL
    SELECT `pgi_religion`, `pgi_client_id` FROM `wx_clk_res`.`prof_general_info`
    UNION ALL
    SELECT `pgi_religion`, `pgi_client_id` FROM `wx_clk_sen`.`prof_general_info`
    UNION ALL
    SELECT `pgi_religion`, `pgi_client_id` FROM `wx_clk_sil`.`prof_general_info`
) AS `temporary_name_we_dont_care_about_religion` WHERE `pgi_client_id`=`emr_client_id` ) AS `Religion`,
(SELECT GROUP_CONCAT(DISTINCT ELT(`pgi_marital`,'Single','Married','Divorced','Separated','Common-Law','Widowed')) FROM (
    SELECT `pgi_marital`, `pgi_client_id` FROM `wx_clk_ccr`.`prof_general_info`
    UNION ALL
    SELECT `pgi_marital`, `pgi_client_id` FROM `wx_clk_co2`.`prof_general_info`
    UNION ALL
    SELECT `pgi_marital`, `pgi_client_id` FROM `wx_clk_com`.`prof_general_info`
    UNION ALL
    SELECT `pgi_marital`, `pgi_client_id` FROM `wx_clk_fs`.`prof_general_info`
    UNION ALL
    SELECT `pgi_marital`, `pgi_client_id` FROM `wx_clk_gan`.`prof_general_info`
    UNION ALL
    SELECT `pgi_marital`, `pgi_client_id` FROM `wx_clk_io`.`prof_general_info` 
    UNION ALL
    SELECT `pgi_marital`, `pgi_client_id` FROM `wx_clk_opt`.`prof_general_info`
    UNION ALL
    SELECT `pgi_marital`, `pgi_client_id` FROM `wx_clk_res`.`prof_general_info`
    UNION ALL
    SELECT `pgi_marital`, `pgi_client_id` FROM `wx_clk_sen`.`prof_general_info`
    UNION ALL
    SELECT `pgi_marital`, `pgi_client_id` FROM `wx_clk_sil`.`prof_general_info`
) AS `temporary_name_we_dont_care_about_marital` WHERE `pgi_client_id`=`emr_client_id` ) AS `Marital Status`,
(SELECT GROUP_CONCAT(DISTINCT ELT(`pgi_caregiver_age`,'Not Applicable','','','','','','','','','','','','','','','','','','','20s','','','','','','','','','','30s','','','','','','','','','','40s','','','','','','','','','','50s','','','','','','','','','','60s','','','','','','','','','','70s','','','','','','','','','','80s')) FROM (
    SELECT `pgi_caregiver_age`, `pgi_client_id` FROM `wx_clk_ccr`.`prof_general_info`
    UNION ALL
    SELECT `pgi_caregiver_age`, `pgi_client_id` FROM `wx_clk_co2`.`prof_general_info`
    UNION ALL
    SELECT `pgi_caregiver_age`, `pgi_client_id` FROM `wx_clk_com`.`prof_general_info`
    UNION ALL
    SELECT `pgi_caregiver_age`, `pgi_client_id` FROM `wx_clk_fs`.`prof_general_info`
    UNION ALL
    SELECT `pgi_caregiver_age`, `pgi_client_id` FROM `wx_clk_gan`.`prof_general_info`
    UNION ALL
    SELECT `pgi_caregiver_age`, `pgi_client_id` FROM `wx_clk_io`.`prof_general_info` 
    UNION ALL
    SELECT `pgi_caregiver_age`, `pgi_client_id` FROM `wx_clk_opt`.`prof_general_info`
    UNION ALL
    SELECT `pgi_caregiver_age`, `pgi_client_id` FROM `wx_clk_res`.`prof_general_info`
    UNION ALL
    SELECT `pgi_caregiver_age`, `pgi_client_id` FROM `wx_clk_sen`.`prof_general_info`
    UNION ALL
    SELECT `pgi_caregiver_age`, `pgi_client_id` FROM `wx_clk_sil`.`prof_general_info`
) AS `temporary_name_we_dont_care_about_caregiver` WHERE `pgi_client_id`=`emr_client_id` ) AS `Primary Caregiver`,
(SELECT GROUP_CONCAT(DISTINCT `pmtt_name`) FROM (
    SELECT `pmtt_name`, `pmt_client_id` FROM `wx_clk_ccr`.`prof_mode_transport` LEFT JOIN `wx_clk_ccr`.`prof_mode_transport_type` ON `prof_mode_transport_type_id`=`pmt_mode_transport_type` 
    UNION ALL
    SELECT `pmtt_name`, `pmt_client_id` FROM `wx_clk_co2`.`prof_mode_transport` LEFT JOIN `wx_clk_co2`.`prof_mode_transport_type` ON `prof_mode_transport_type_id`=`pmt_mode_transport_type` 
    UNION ALL
    SELECT `pmtt_name`, `pmt_client_id` FROM `wx_clk_com`.`prof_mode_transport` LEFT JOIN `wx_clk_com`.`prof_mode_transport_type` ON `prof_mode_transport_type_id`=`pmt_mode_transport_type` 
    UNION ALL
    SELECT `pmtt_name`, `pmt_client_id` FROM `wx_clk_fs`.`prof_mode_transport` LEFT JOIN `wx_clk_fs`.`prof_mode_transport_type` ON `prof_mode_transport_type_id`=`pmt_mode_transport_type` 
    UNION ALL
    SELECT `pmtt_name`, `pmt_client_id` FROM `wx_clk_gan`.`prof_mode_transport` LEFT JOIN `wx_clk_gan`.`prof_mode_transport_type` ON `prof_mode_transport_type_id`=`pmt_mode_transport_type` 
    UNION ALL
    SELECT `pmtt_name`, `pmt_client_id` FROM `wx_clk_io`.`prof_mode_transport` LEFT JOIN `wx_clk_io`.`prof_mode_transport_type` ON `prof_mode_transport_type_id`=`pmt_mode_transport_type` 
    UNION ALL
    SELECT `pmtt_name`, `pmt_client_id` FROM `wx_clk_opt`.`prof_mode_transport` LEFT JOIN `wx_clk_opt`.`prof_mode_transport_type` ON `prof_mode_transport_type_id`=`pmt_mode_transport_type` 
    UNION ALL
    SELECT `pmtt_name`, `pmt_client_id` FROM `wx_clk_res`.`prof_mode_transport` LEFT JOIN `wx_clk_res`.`prof_mode_transport_type` ON `prof_mode_transport_type_id`=`pmt_mode_transport_type` 
    UNION ALL
    SELECT `pmtt_name`, `pmt_client_id` FROM `wx_clk_sen`.`prof_mode_transport` LEFT JOIN `wx_clk_sen`.`prof_mode_transport_type` ON `prof_mode_transport_type_id`=`pmt_mode_transport_type` 
    UNION ALL
    SELECT `pmtt_name`, `pmt_client_id` FROM `wx_clk_sil`.`prof_mode_transport` LEFT JOIN `wx_clk_sil`.`prof_mode_transport_type` ON `prof_mode_transport_type_id`=`pmt_mode_transport_type` 
) AS `temporary_name_we_dont_care_about_transport` WHERE `pmt_client_id`=`emr_client_id` ) AS `Transport`,
(SELECT GROUP_CONCAT(DISTINCT `pcmt_name`) FROM (
    SELECT `pcmt_name`, `pcm_client_id` FROM `wx_clk_ccr`.`prof_communication` LEFT JOIN `wx_clk_ccr`.`prof_communication_type` ON `prof_communication_type_id`=`pcm_communication_type` 
    UNION ALL
    SELECT `pcmt_name`, `pcm_client_id` FROM `wx_clk_co2`.`prof_communication` LEFT JOIN `wx_clk_co2`.`prof_communication_type` ON `prof_communication_type_id`=`pcm_communication_type` 
    UNION ALL
    SELECT `pcmt_name`, `pcm_client_id` FROM `wx_clk_com`.`prof_communication` LEFT JOIN `wx_clk_com`.`prof_communication_type` ON `prof_communication_type_id`=`pcm_communication_type` 
    UNION ALL
    SELECT `pcmt_name`, `pcm_client_id` FROM `wx_clk_fs`.`prof_communication` LEFT JOIN `wx_clk_fs`.`prof_communication_type` ON `prof_communication_type_id`=`pcm_communication_type` 
    UNION ALL
    SELECT `pcmt_name`, `pcm_client_id` FROM `wx_clk_gan`.`prof_communication` LEFT JOIN `wx_clk_gan`.`prof_communication_type` ON `prof_communication_type_id`=`pcm_communication_type` 
    UNION ALL
    SELECT `pcmt_name`, `pcm_client_id` FROM `wx_clk_io`.`prof_communication` LEFT JOIN `wx_clk_io`.`prof_communication_type` ON `prof_communication_type_id`=`pcm_communication_type` 
    UNION ALL
    SELECT `pcmt_name`, `pcm_client_id` FROM `wx_clk_opt`.`prof_communication` LEFT JOIN `wx_clk_opt`.`prof_communication_type` ON `prof_communication_type_id`=`pcm_communication_type` 
    UNION ALL
    SELECT `pcmt_name`, `pcm_client_id` FROM `wx_clk_res`.`prof_communication` LEFT JOIN `wx_clk_res`.`prof_communication_type` ON `prof_communication_type_id`=`pcm_communication_type` 
    UNION ALL
    SELECT `pcmt_name`, `pcm_client_id` FROM `wx_clk_sen`.`prof_communication` LEFT JOIN `wx_clk_sen`.`prof_communication_type` ON `prof_communication_type_id`=`pcm_communication_type` 
    UNION ALL
    SELECT `pcmt_name`, `pcm_client_id` FROM `wx_clk_sil`.`prof_communication` LEFT JOIN `wx_clk_sil`.`prof_communication_type` ON `prof_communication_type_id`=`pcm_communication_type` 
) AS `temporary_name_we_dont_care_about_communication` WHERE `pcm_client_id`=`emr_client_id` ) AS `Communication`,
(SELECT COUNT(*) FROM `incident_report` LEFT JOIN `incident_client` ON `incident_report_id`=`incident_id` WHERE `emr_client_id`=`client_id` AND `ir_ecr`='res') AS `Incident Reports`,
(SELECT GROUP_CONCAT(DISTINCT `pdt_name`) FROM `prof_diagnosis` LEFT JOIN `prof_diagnosis_type` ON `pdi_diagnosis_type`=`prof_diagnosis_type_id` WHERE `emr_client_id`=`pdi_client_id`) AS `Diagnosis`,
(SELECT GROUP_CONCAT(DISTINCT `phft_name`) FROM `prof_health_factor` LEFT JOIN `prof_health_factor_type` ON `phf_health_factor_type`=`prof_health_factor_type_id` WHERE `emr_client_id`=`phf_client_id`) AS `Health Factors`
FROM `emr_client`
SQL;


        $query = new Select();
        $query->select(colAs('ecl_file_no','File Number'));
        $query->select(colAs('ecl_name','Persons Name'));
        $query->select(new ExprAs(new UserFunc('ts2d',col('ecl_birth_date')),new FieldAlias('DOB')));
        $query->select(colAs('ecl_gender','Gender'));

        $dbNames = [
            'wx_clk_ccr',
            'wx_clk_co2',
            'wx_clk_com',
            'wx_clk_fs',
            'wx_clk_gan',
            'wx_clk_io',
            'wx_clk_opt',
            'wx_clk_res',
            'wx_clk_sen',
            'wx_clk_sil',
        ];
        
        $programs = (new Select())
            ->select(Agg::groupConcat([col('epg_name')],true))
            ->from(new SelectTable($programUnion = new UnionAll(),new TableAlias('temporary_name_we_dont_care_about_program')))
            ->where(eq(col('ecp_client_id'), col('emr_client_id')))
            ;
        
        foreach($dbNames as $dbName) {
            $programUnion->push((new Select())->select(col('epg_name'),col('ecp_client_id'))->from(new Table('emr_client_program', new Database($dbName)))->leftJoin(new Table('emr_program'),eq(col('ecp_program_id'),col('emr_program_id'))));
        }

        $query->select(new ExprAs($programs->toExpr(),new FieldAlias('Programs')));

        $familyInvolvement = (new Select())
            ->select(Agg::groupConcat([Str::elt(col('pgi_family'),new Value('High Level'),new Value('Limited'),new Value('Moderate'), new Value('None'))],true))
            ->from(new SelectTable($generalInfoUnion = new UnionAll(),new TableAlias('temporary_name_we_dont_care_about_family_inv')))
            ->where(eqCols('pgi_client_id','emr_client_id'))
        ;

        foreach($dbNames as $dbName) {
            $generalInfoUnion->push((new Select())->select(col('pgi_family'),col('pgi_client_id'))->from(new Table('prof_general_info', new Database($dbName))));
        }

        $query->select(new ExprAs($familyInvolvement->toExpr(),new FieldAlias('Family Involvement')));


        $levels = values('High Level','Limited','Moderate','None');
        $friendInvolvement = (new Select())
            ->select(Agg::groupConcat([Str::elt(col('pgi_friend'),...$levels)],true))
            ->from(new SelectTable($friendUnion = new UnionAll(),new TableAlias('temporary_name_we_dont_care_about_friend_inv')))
            ->where(eq(col('pgi_client_id'), col('emr_client_id')))
        ;

        foreach($dbNames as $dbName) {
            $friendUnion->push((new Select())->select(col('pgi_friend'),col('pgi_client_id'))->from(new Table('prof_general_info', new Database($dbName))));
        }

        $query->select(new ExprAs($friendInvolvement->toExpr(),new FieldAlias('Friend Involvement')));

        /////////////////////////////////////////////

        $mobilityEnum = values('Assisted Wheelchair','Self Propelled Wheelchair','Walker / Cane','Walks Assisted','Walks Independently','Pre-Walking');

        $mobilitySelect = (new Select())
            ->select(Agg::groupConcat([Str::elt(col('pgi_mobility'),...$mobilityEnum)],true))
            ->from(new SelectTable($mobilityUnion = new UnionAll(),new TableAlias('temporary_name_we_dont_care_about_mobility')))
            ->where(eq(col('pgi_client_id'), col('emr_client_id')))
        ;

        foreach($dbNames as $dbName) {
            $mobilityUnion->push((new Select())->select(col('pgi_mobility'),col('pgi_client_id'))->from(new Table('prof_general_info', new Database($dbName))));
        }

        $query->select(new ExprAs($mobilitySelect->toExpr(),new FieldAlias('Mobility')));

        /////////////////////////////////////////////


        $religionSelect = (new Select())
            ->select(Agg::groupConcat([Str::elt(col('pgi_religion'),...values('Anglican','Catholic','Jewish','Jehovah\'s Witness','Muslim','Protestant','Roman Catholic','Sikh','United','Atheist','Agnostic','Non-Religion','Christian','Other','Presbyterian','Baptist','Greek Orthodox','Lutheran','Methodist','Mormon','New Episcopal','Pentecostal','Salvation Army','Seventh Day Adventist','Evangelist','Brethren','Buddhist','Islam','Mennonite','New Apostolic','Orthodox'))],true))
        ;

        $religionUnion = new UnionAll();
        foreach($dbNames as $dbName) {
            $religionUnion->push((new Select())->select(col('pgi_religion'),col('pgi_client_id'))->from(new Table('prof_general_info', new Database($dbName))));
        }

        $religionSelect
            ->from($religionUnion->toTable(talias('temporary_name_we_dont_care_about_religion')))
            ->where(eq(col('pgi_client_id'), col('emr_client_id')))
            ;
        $query->select(new ExprAs($religionSelect->toExpr(),new FieldAlias('Religion')));

        /////////////////////////////////////////////


        $religionSelect = (new Select())
            ->select(Agg::groupConcat([Str::elt(col('pgi_marital'),...values('Single','Married','Divorced','Separated','Common-Law','Widowed'))],true))
        ;

        $religionUnion = new UnionAll();
        foreach($dbNames as $dbName) {
            $religionUnion->push((new Select())->select(...columns('pgi_marital','pgi_client_id'))->from(new Table('prof_general_info', new Database($dbName))));
        }

        $religionSelect
            ->from($religionUnion->toTable(talias('temporary_name_we_dont_care_about_marital')))
            ->where(eq(col('pgi_client_id'), col('emr_client_id')))
        ;
        $query->select(new ExprAs($religionSelect->toExpr(),new FieldAlias('Marital Status')));

        /////////////////////////////////////////////

        $religionSelect = (new Select())
            ->select(Agg::groupConcat([Str::elt(col('pgi_caregiver_age'),...values('Not Applicable','','','','','','','','','','','','','','','','','','','20s','','','','','','','','','','30s','','','','','','','','','','40s','','','','','','','','','','50s','','','','','','','','','','60s','','','','','','','','','','70s','','','','','','','','','','80s'))],true))
        ;

        $religionUnion = new UnionAll();
        foreach($dbNames as $dbName) {
            $religionUnion->push((new Select())->select(...columns('pgi_caregiver_age','pgi_client_id'))->from(new Table('prof_general_info', new Database($dbName))));
        }

        $religionSelect
            ->from($religionUnion->toTable(talias('temporary_name_we_dont_care_about_caregiver')))
            ->where(eq(col('pgi_client_id'), col('emr_client_id')))
        ;
        $query->select(new ExprAs($religionSelect->toExpr(),new FieldAlias('Primary Caregiver')));

        /////////////////////////////////////////////

        $transportSelect = (new Select())
            ->select(Agg::groupConcat(columns('pmtt_name'),true))
        ;

        $transportUnion = new UnionAll();
        foreach($dbNames as $dbName) {
            $transportUnion->push((new Select())->select(...columns('pmtt_name','pmt_client_id'))->from(tbl('prof_mode_transport', $dbName))->leftJoin(tbl('prof_mode_transport_type',$dbName),eqCols('prof_mode_transport_type_id','pmt_mode_transport_type')));
        }

        $transportSelect
            ->from($transportUnion->toTable(talias('temporary_name_we_dont_care_about_transport')))
            ->where(eqCols('pmt_client_id','emr_client_id'))
        ;
        $query->select(exprAlias($transportSelect->toExpr(),'Transport'));

        /////////////////////////////////////////////

        $commSelect = (new Select())
            ->select(Agg::groupConcat(columns('pcmt_name'),true))
        ;

        $commUnion = new UnionAll();
        foreach($dbNames as $dbName) {
            $commUnion->push((new Select())->select(...columns('pcmt_name','pcm_client_id'))
                ->from(tbl('prof_communication', $dbName))
                ->leftJoin(tbl('prof_communication_type',$dbName),eqCols('prof_communication_type_id','pcm_communication_type')));
        }

        $commSelect
            ->from($commUnion->toTable(talias('temporary_name_we_dont_care_about_communication')))
            ->where(eqCols('pcm_client_id','emr_client_id'))
        ;
        $query->select(exprAlias($commSelect->toExpr(),'Communication'));


        /////////////////////////////////////////////

        $countIncidents = (new Select())
            ->select(Agg::countRows())
            ->from(tbl('incident_report'))
            ->leftJoin(tbl('incident_client'),eqCols('incident_report_id','incident_id'))
            ->where(new LogAnd(eqCols('emr_client_id','client_id'),eqColVal('ir_ecr','res')));

        $query->select(selectAs($countIncidents,'Incident Reports'));

        $diagnosis = (new Select())
            ->select(Agg::groupConcat(columns('pdt_name'),true))
            ->from(tbl('prof_diagnosis'))
            ->leftJoin(tbl('prof_diagnosis_type'),eqCols('pdi_diagnosis_type','prof_diagnosis_type_id'))
            ->where(eqCols('emr_client_id','pdi_client_id'));

        $query->select(selectAs($diagnosis,'Diagnosis'));

        $healthFactors = (new Select())
            ->select(Agg::groupConcat(columns('phft_name'),true))
            ->from(tbl('prof_health_factor'))
            ->leftJoin(tbl('prof_health_factor_type'),eqCols('phf_health_factor_type','prof_health_factor_type_id'))
            ->where(eqCols('emr_client_id','phf_client_id'));

        $query->select(selectAs($healthFactors,'Health Factors'));
        $query->from(tbl('emr_client'));

        /////////////////////////////////////////////

        $this->assertSimilar($sql, $query->toSql($this->conn));
    }
}
