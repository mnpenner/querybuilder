<?php
use QueryBuilder\Asterisk;
use QueryBuilder\Column;
use QueryBuilder\Connections\AbstractMySqlConnection;
use QueryBuilder\Database;
use QueryBuilder\Dual;
use QueryBuilder\FieldAlias;
use QueryBuilder\FieldAs;
use QueryBuilder\Functions\Count;
use QueryBuilder\Functions\Stmt;
use QueryBuilder\HexLiteral;
use QueryBuilder\Interval;
use QueryBuilder\MySql\Functions\Agg;
use QueryBuilder\MySql\Functions\Math;
use QueryBuilder\MySql\Functions\String;
use QueryBuilder\MySql\Keywords\Charset;
use QueryBuilder\MySql\Keywords\Collation;
use QueryBuilder\Operator\Add;
use QueryBuilder\Operator\Assign;
use QueryBuilder\Operator\Bang;
use QueryBuilder\Operator\Between;
use QueryBuilder\Operator\BitwiseOr;
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
use QueryBuilder\StringLiteral;
use QueryBuilder\SubQueryTable;
use QueryBuilder\Table;
use QueryBuilder\TableAlias;
use QueryBuilder\TableAs;
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
        $iso8859conn = new \QueryBuilder\Connections\FakeMySqlConnection('iso-8859-1', false);

        // 0x5c = \
        // 0x27 = '

        // if the server charset is actually `gbk` then 0xbf5c will be interpreted as a single character,
        // and this query will actually look something like: SELECT * FROM test WHERE name = '縗' OR 1=1 /*' LIMIT 1
        // which of course a successful SQL injection attack; see http://stackoverflow.com/a/12118602/65387
        $select1 = (new Select())->fields(new Value("\xbf\x27 OR 1=1 /*"));
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
        $select2 = (new Select())->fields(new Value("\x83\x27 OR 1=1 /*"));
        $this->assertSimilar("SELECT '\x83\x5c\x27 OR 1=1 /*'",$iso8859conn->render($select1),"SQL injection");

        foreach(['cp932', 'sjis'] as $charset) {
            $cp932conn = new \QueryBuilder\Connections\FakeMySqlConnection($charset, false);
            $this->assertSimilar("SELECT '\x83\x27 OR 1=1 /*'", $cp932conn->render($select2), "SQL injection averted for $charset");
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

    function testAsteriskNoError() {
        (new Select())
            ->from(new Table('t1'))
            ->fields(new Asterisk, new Column('x'))->toSql($this->conn);
    }

    function testAsteriskError() {
        $this->setExpectedException(\Exception::class, "unqualified *");
        (new Select())
            ->from(new Table('t1'))
            ->fields(new Column('x'),new Asterisk)->toSql($this->conn);
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
            ->fields(new Asterisk);
        $this->assertSimilar("SELECT * FROM `t1`",$select->toSql($this->conn)); // this test has to run on its own, otherwise it will generate a warning (see testAsteriskWarning)

        $table2 = new Table('t2',new Database('db'));
        $select = (new Select())
            ->from($table1)
            ->fields(new Asterisk($table1), new Asterisk($table2));

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
        $this->assertSimilar("SELECT `c1` FROM `t1` UNION SELECT `c2` FROM `t2` UNION SELECT `c3` FROM `t3` LIMIT 50 OFFSET 100",$union->copy()->limit(50)->offset(100)->push($select3)->toSql($this->conn));
        $this->assertSimilar("SELECT `c1` FROM `t1` UNION SELECT `c2` FROM `t2`",$union->toSql($this->conn));

        $unionAll = new UnionAll();
        $unionAll->push($select1);
        $unionAll->push($select2);
        $this->assertSimilar("SELECT `c1` FROM `t1` UNION ALL SELECT `c2` FROM `t2` UNION ALL SELECT `c3` FROM `t3` LIMIT 50 OFFSET 100",$unionAll->copy()->limit(50)->offset(100)->push($select3)->toSql($this->conn));
        $this->assertSimilar("SELECT `c1` FROM `t1` UNION ALL SELECT `c2` FROM `t2`",$unionAll->toSql($this->conn));

        $countAlias = new FieldAlias('count');
        $unionCount = (new UnionAll(
            (new Select())->from(new Table('t1'))->fields(new FieldAs(Count::all(),$countAlias)),
            (new Select())->from(new Table('t2'))->fields(Count::all())
        ));
        $select = (new Select())->fields(Agg::sum($countAlias))->from(new SubQueryTable($unionCount,new TableAlias('t3')));

        $this->assertSimilar("SELECT SUM(`count`) FROM (SELECT COUNT(*) AS `count` FROM `t1` UNION ALL SELECT COUNT(*) FROM `t2`) AS `t3`",$select->toSql($this->conn),"total number of rows across multiple tables");

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
        $this->assertSimilar("SELECT 0 AND 1 AND 2 AND 3 AND 4 AND (5 OR 6)",$select->toSql($this->conn));

        $select = (new Select())->fields(new Assign(new UserVariable('x'),new LogicalOr($zero,new LogicalXor($one, new LogicalAnd($two,new Not($three))))));
        $this->assertSimilar("SELECT @x := 0 OR 1 XOR 2 AND NOT 3",$select->toSql($this->conn));

        $select = (new Select())->fields(new LogicalAnd($two,new LogicalXor($zero,new LogicalOr($one, new Assign(new UserVariable('x'),new Not($three))))));
        $this->assertSimilar("SELECT 2 AND (0 XOR (1 OR (@x := NOT 3)))",$select->toSql($this->conn));

        $this->assertSimilar("SELECT '2008-12-31 23:59:59' + INTERVAL 1 SECOND",Stmt::select()->fields(new Add(new Value('2008-12-31 23:59:59'),new Interval(new Value(1), Interval::SECOND())))->toSql($this->conn));
        $this->assertSimilar("SELECT INTERVAL 1 DAY + '2008-12-31'",Stmt::select()->fields(new Add(new Interval(new Value(1), Interval::DAY()),new Value('2008-12-31')))->toSql($this->conn));
    }

    function testSelect() {
        $dual = new Dual;

        $select = (new Select())
            ->fields(new Asterisk)
            ->from(new Table('wx_user'));
        $this->assertSimilar("SELECT * FROM `wx_user`",$select->toSql($this->conn));

        $eafkDatabase = new Database('wx_eafk_dso');
        $clientTable = new Table('emr_client',$eafkDatabase);
        $clientAlias = new TableAlias('client');
        $select = (new Select())
            ->fields(new Column('ecl_name',$clientTable), new FieldAs(new Column('ecl_birth_date',$clientAlias),new FieldAlias('dob')))
            ->from(new TableAs(new Table('emr_client', $eafkDatabase), $clientAlias));
        $this->assertSimilar("SELECT `wx_eafk_dso`.`emr_client`.`ecl_name`, `client`.`ecl_birth_date` AS `dob` FROM `wx_eafk_dso`.`emr_client` AS `client`",$select->toSql($this->conn));

        $select = (new Select())
            ->fields(new Asterisk)
            ->from($dual);
        $this->assertSimilar("SELECT * FROM DUAL",$select->toSql($this->conn));



        $select = (new Select())
            ->fields(Agg::exists((new Select())
                ->fields(new Asterisk)
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
        $this->assertSimilar('SELECT ABS(2)',(new Select())->fields(Math::abs($two))->toSql($this->conn));
        $this->assertSimilar('SELECT ACOS(1)',(new Select())->fields(Math::acos($one))->toSql($this->conn));
        $this->assertSimilar('SELECT ATAN(2)',(new Select())->fields(Math::atan($two))->toSql($this->conn));
        $this->assertSimilar('SELECT ATAN(-2, 2)',(new Select())->fields(Math::atan(new Value(-2), $two))->toSql($this->conn));
        $this->assertSimilar('SELECT ATAN2(-2, 2)',(new Select())->fields(Math::atan2(new Value(-2), $two))->toSql($this->conn));
        $this->assertSimilar('SELECT CEILING(1.23)',(new Select())->fields(Math::ceil(new Value(1.23)))->toSql($this->conn));
        $this->assertSimilar("SELECT CONV('a', 16, 2)",(new Select())->fields(Math::conv(new Value('a'), new Value(16), $two))->toSql($this->conn));
        $this->assertSimilar("SELECT COS(1)",(new Select())->fields(Math::cos($one))->toSql($this->conn));
        $this->assertSimilar("SELECT COT(1)",(new Select())->fields(Math::cot($one))->toSql($this->conn));
        $this->assertSimilar("SELECT CRC32('MySQL')",(new Select())->fields(Math::crc32(new Value('MySQL')))->toSql($this->conn));
        $this->assertSimilar("SELECT DEGREES(1)",(new Select())->fields(Math::degrees($one))->toSql($this->conn));
        $this->assertSimilar("SELECT EXP(1)",(new Select())->fields(Math::exp($one))->toSql($this->conn));
        $this->assertSimilar("SELECT FLOOR(1)",(new Select())->fields(Math::floor($one))->toSql($this->conn));
        $this->assertSimilar("SELECT FORMAT(12332.123456, 4)",(new Select())->fields(Math::format(new Value(12332.123456),new Value(4)))->toSql($this->conn));
        $this->assertSimilar("SELECT FORMAT(12332.2,2,'de_DE')",(new Select())->fields(Math::format(new Value(12332.2),new Value(2), new Value('de_DE')))->toSql($this->conn));
        $this->assertSimilar("SELECT FORMAT(12332.2,2,'de_DE')",(new Select())->fields(Math::format(new Value(12332.2),new Value(2), new Value('de_DE')))->toSql($this->conn));
        $hexAbc = Math::hex(new Value('abc'));
        $this->assertSimilar("SELECT 0x616263, 0x616263, HEX('abc'), UNHEX(HEX('abc'))",(new Select())->fields(
            new HexLiteral(0x616263), new HexLiteral('abc'), $hexAbc, String::unhex($hexAbc)
        )->toSql($this->conn));
        $this->assertSimilar("SELECT LN(2)",(new Select())->fields(Math::ln($two))->toSql($this->conn));
        $this->assertSimilar("SELECT LOG(2)",(new Select())->fields(Math::log($two))->toSql($this->conn));
        $this->assertSimilar("SELECT LOG(2, 1)",(new Select())->fields(Math::log($two, $one))->toSql($this->conn));
        $this->assertSimilar("SELECT LOG2(2)",(new Select())->fields(Math::log2($two))->toSql($this->conn));
        $this->assertSimilar("SELECT LOG10(2)",(new Select())->fields(Math::log10($two))->toSql($this->conn));
        $this->assertSimilar("SELECT MOD(234, 10)",(new Select())->fields(Math::mod(new Value(234), new Value(10)))->toSql($this->conn));
        $this->assertSimilar("SELECT MOD(29, 9)",(new Select())->fields(Math::mod(new Value(29), new Value(9)))->toSql($this->conn));
        $this->assertSimilar("SELECT MOD(34.5, 3)",(new Select())->fields(Math::mod(new Value(34.5), new Value(3)))->toSql($this->conn));
        $this->assertSimilar("SELECT PI()",(new Select())->fields(Math::pi())->toSql($this->conn));
        $this->assertSimilar("SELECT POW(2, 2)",(new Select())->fields(Math::pow($two, $two))->toSql($this->conn));
        $this->assertSimilar("SELECT RADIANS(90)",(new Select())->fields(Math::radians(new Value(90)))->toSql($this->conn));
        $this->assertSimilar("SELECT RAND(), RAND(3)",(new Select())->fields(Math::rand(), Math::rand(new Value(3)))->toSql($this->conn));
        $this->assertSimilar("SELECT FLOOR(7 + RAND() * (12 - 7))",(new Select())->fields(Math::randInt(new Value(7), new Value(12)))->toSql($this->conn));
        $this->assertSimilar("SELECT FLOOR(7 + RAND(3) * (12 - 7))",(new Select())->fields(Math::randInt(new Value(7), new Value(12), new Value(3)))->toSql($this->conn));
        $this->assertSimilar("SELECT ROUND(-1.23)",(new Select())->fields(Math::round(new Value(-1.23)))->toSql($this->conn));
        $this->assertSimilar("SELECT ROUND(1.298, 1)",(new Select())->fields(Math::round(new Value(1.298), new Value(1)))->toSql($this->conn));
        $this->assertSimilar("SELECT SIGN(2.5)",(new Select())->fields(Math::sign(new Value(2.5)))->toSql($this->conn));
        $this->assertSimilar("SELECT SIN(PI())",(new Select())->fields(Math::sin(Math::pi()))->toSql($this->conn));
        $this->assertSimilar("SELECT SQRT(4)",(new Select())->fields(Math::sqrt(new Value(4)))->toSql($this->conn));
        $this->assertSimilar("SELECT TAN(PI())",(new Select())->fields(Math::tan(Math::pi()))->toSql($this->conn));
        $this->assertSimilar("SELECT TRUNCATE(1.223,1)",(new Select())->fields(Math::truncate(new Value(1.223), new Value(1)))->toSql($this->conn));
    }

    function testStringFuncs() {
        $this->assertSimilar("SELECT CHAR(77,121,83,81,'76')",(new Select())->fields(String::char(new Value(77), new Value(121), new Value(83), new Value(81), new Value('76')))->toSql($this->conn));
        $this->assertSimilar("SELECT CHAR(0x65 USING utf8)",(new Select())->fields(String::charUsing(Charset::utf8(), new HexLiteral(101)))->toSql($this->conn));
        $this->assertSimilar("SELECT CHAR_LENGTH('Hello world')",(new Select())->fields(String::charLength(new Value('Hello world')))->toSql($this->conn));
        $this->assertSimilar("SELECT CONCAT_WS(',','First name','Second name','Last Name')",(new Select())->fields(String::concatWS(new Value(','),new Value('First name'),new Value('Second name'),new Value('Last name')))->toSql($this->conn));
        $this->assertSimilar("SELECT EXPORT_SET(5,'Y','N',',',4)",(new Select())->fields(String::exportSet(new Value(5), new Value('Y'), new Value('N'), new Value(','), new Value(4)))->toSql($this->conn));
        $this->assertSimilar("SELECT FIELD('ej', 'Hej', 'ej', 'Heja', 'hej', 'foo')",(new Select())->fields(String::field(new Value('ej'),new Value('Hej'),new Value('ej'),new Value('Heja'),new Value('hej'),new Value('foo')))->toSql($this->conn));
        $this->assertSimilar("SELECT MAKE_SET(1 | 4,'hello','nice','world')",(new Select())->fields(
            String::makeSet(new BitwiseOr(new Value(1), new Value(4)), new Value('hello'), new Value('nice'), new Value('world'))
        )->toSql($this->conn));

        $this->assertSimilar("SELECT TRIM('  bar   ')",Stmt::select()->fields(String::trim(new Value('  bar   ')))->toSql($this->conn));
        $this->assertSimilar("SELECT TRIM(LEADING 'x' FROM 'xxxbarxxx')",Stmt::select()->fields(String::trimLeading(new Value('xxxbarxxx'),new Value('x')))->toSql($this->conn));
        $this->assertSimilar("SELECT TRIM(BOTH 'x' FROM 'xxxbarxxx')",Stmt::select()->fields(String::trim(new Value('xxxbarxxx'),new Value('x')))->toSql($this->conn));
        $this->assertSimilar("SELECT TRIM(TRAILING 'xyz' FROM 'barxxyz')",Stmt::select()->fields(String::trimTrailing(new Value('barxxyz'),new Value('xyz')))->toSql($this->conn));

        $this->assertSimilar("SELECT WEIGHT_STRING(@s)",Stmt::select()->fields(String::weightString(new UserVariable('s')))->toSql($this->conn));
        $this->assertSimilar("SELECT WEIGHT_STRING('ab' AS CHAR(4))",Stmt::select()->fields(String::weightString(new StringLiteral('ab'), 'CHAR(4)'))->toSql($this->conn));
        $this->assertSimilar("SELECT WEIGHT_STRING(0x7FFF LEVEL 1 DESC REVERSE)",Stmt::select()->fields(String::weightString(new HexLiteral(0x7FFF), null, '1 DESC REVERSE'))->toSql($this->conn));
        $this->assertSimilar("SELECT WEIGHT_STRING('xy' AS BINARY(8) LEVEL 1-3)",Stmt::select()->fields(String::weightString(new StringLiteral('xy'), 'BINARY(8)', '1-3'))->toSql($this->conn));
        $this->assertSimilar("SELECT WEIGHT_STRING('x' LEVEL 2, 3, 5)",Stmt::select()->fields(String::weightString(new StringLiteral('x'), null, [2,3,5]))->toSql($this->conn));
        $this->assertSimilar("SELECT WEIGHT_STRING('x' LEVEL 1 ASC, 2 DESC, 3 REVERSE)",Stmt::select()->fields(String::weightString(new StringLiteral('x'), null, ['1 ASC', '2 DESC', '3 REVERSE']))->toSql($this->conn));

        $this->assertSimilar("SELECT CONCAT('My', 'S', 'QL')",Stmt::select()->fields(String::concat(new StringLiteral('My'),new StringLiteral('S'),new StringLiteral('QL')))->toSql($this->conn));
        $this->assertSimilar("SELECT CONCAT('My', NULL, 'QL')",Stmt::select()->fields(String::concat(new StringLiteral('My'),new Value(null),new StringLiteral('QL')))->toSql($this->conn));
        $this->assertSimilar("SELECT CONCAT(14.3)",Stmt::select()->fields(String::concat(new Value(14.3)))->toSql($this->conn));
    }

    function testStringLiteral() {
        // see https://dev.mysql.com/doc/refman/5.7/en/string-literals.html
        $this->assertEquals("SELECT 'string'", (new Select())->fields(new StringLiteral('string'))->toSql($this->conn));
        $this->assertEquals("SELECT _latin1'string'", (new Select())->fields(new StringLiteral('string', Charset::latin1()))->toSql($this->conn));
        $this->assertEquals("SELECT _latin1'string' COLLATE latin1_danish_ci", (new Select())->fields(new StringLiteral('string', Charset::latin1(), Collation::latin1_danish_ci()))->toSql($this->conn));
    }

    function testAggregateFuncs() {
        $select = Stmt::select()
            ->fields(Agg::exists(Stmt::select(new Dual())
                    ->fields(new Asterisk)
                    ->where(new Value(0)))
            );
        $this->assertSimilar("SELECT EXISTS(SELECT * FROM DUAL WHERE 0)",$select->toSql($this->conn));
        $this->assertSimilar("SELECT SUM(`amount`)",Stmt::select()->fields(Agg::sum(new Column('amount')))->toSql($this->conn));
        $this->assertSimilar("SELECT SUM(DISTINCT `amount`)",Stmt::select()->fields(Agg::sum(new Column('amount'),true))->toSql($this->conn));
        $this->assertSimilar("SELECT COUNT(*)",Stmt::select()->fields(Agg::countRows())->toSql($this->conn));
        $this->assertSimilar("SELECT COUNT(`name`)",Stmt::select()->fields(Agg::countNonNull(new Column('name')))->toSql($this->conn));
        $this->assertSimilar("SELECT COUNT(DISTINCT `first_name`, `last_name`)",Stmt::select()->fields(Agg::countDistinct(new Column('first_name'),new Column('last_name')))->toSql($this->conn));
    }

    function testHex() {
        // https://dev.mysql.com/doc/refman/5.7/en/hexadecimal-literals.html
        $this->assertSimilar("SELECT 0x0a",Stmt::select()->fields(new HexLiteral("0x0a",true))->toSql($this->conn));
        $this->assertSimilar("SELECT 0xaaa",Stmt::select()->fields(new HexLiteral("0xaaa",true))->toSql($this->conn));
        $this->assertSimilar("SELECT X'4D7953514C'",Stmt::select()->fields(new HexLiteral("X'4D7953514C'",true))->toSql($this->conn));
        $this->assertSimilar("SELECT 0x5061756c",Stmt::select()->fields(new HexLiteral("0x5061756c",true))->toSql($this->conn));
        $this->assertSimilar("SELECT 0xacbd18db4cc2f85cedef654fccc4a4d8",Stmt::select()->fields(new HexLiteral(md5('foo'),true))->toSql($this->conn));
        $this->assertSimilar("SELECT 0xACBD18DB4CC2F85CEDEF654FCCC4A4D8",Stmt::select()->fields(new HexLiteral(md5('foo',true),false))->toSql($this->conn));
        $this->assertSimilar("SELECT 0xA",Stmt::select()->fields(new HexLiteral(10))->toSql($this->conn));
    }

    function testHexEx() {
        $this->setExpectedException(\Exception::class);
        new HexLiteral("X'4D7953514'",true); // For values written using X'val' or x'val' format, val must contain an even number of digits.
    }

    function testTimeFuncs() {
        $this->assertSimilar("SELECT CONVERT_TZ(DATE_ADD('1970-01-01', INTERVAL 567082800 SECOND),'UTC',@@session.time_zone)",Stmt::select()->fields(\QueryBuilder\MySql\Functions\Time::unixToDateTime(new Value(567082800)))->toSql($this->conn));
    }

    function testHardcore() {
$sql = <<<'SQL'
select `emr_client_id` as `0`, `ecl_first_name` as `1`, `ecl_middle_name` as `2`, `ecl_last_name` as `3`, `ecl_birth_date` as `4`, (select min(`ecp_discharge_date`) from (select `ecp_discharge_date`, `ecp_client_id` from `wx_clk_io`.`emr_client_program` inner join `wx_clk_io`.`emr_discharge_reason` on `emr_discharge_reason_id` = `ecp_discharge_reason_id` where (`dch_name` like '%deceased%' or `dch_name` like '%death%') union all select `ecp_discharge_date`, `ecp_client_id` from `wx_clk_fs`.`emr_client_program` inner join `wx_clk_fs`.`emr_discharge_reason` on `emr_discharge_reason_id` = `ecp_discharge_reason_id` where (`dch_name` like '%deceased%' or `dch_name` like '%death%') union all select `ecp_discharge_date`, `ecp_client_id` from `wx_clk_com`.`emr_client_program` inner join `wx_clk_com`.`emr_discharge_reason` on `emr_discharge_reason_id` = `ecp_discharge_reason_id` where (`dch_name` like '%deceased%' or `dch_name` like '%death%') union all select `ecp_discharge_date`, `ecp_client_id` from `wx_clk_sil`.`emr_client_program` inner join `wx_clk_sil`.`emr_discharge_reason` on `emr_discharge_reason_id` = `ecp_discharge_reason_id` where (`dch_name` like '%deceased%' or `dch_name` like '%death%') union all select `ecp_discharge_date`, `ecp_client_id` from `wx_clk_opt`.`emr_client_program` inner join `wx_clk_opt`.`emr_discharge_reason` on `emr_discharge_reason_id` = `ecp_discharge_reason_id` where (`dch_name` like '%deceased%' or `dch_name` like '%death%') union all select `ecp_discharge_date`, `ecp_client_id` from `wx_clk_res`.`emr_client_program` inner join `wx_clk_res`.`emr_discharge_reason` on `emr_discharge_reason_id` = `ecp_discharge_reason_id` where (`dch_name` like '%deceased%' or `dch_name` like '%death%') union all select `ecp_discharge_date`, `ecp_client_id` from `wx_clk_ccr`.`emr_client_program` inner join `wx_clk_ccr`.`emr_discharge_reason` on `emr_discharge_reason_id` = `ecp_discharge_reason_id` where (`dch_name` like '%deceased%' or `dch_name` like '%death%') union all select `ecp_discharge_date`, `ecp_client_id` from `wx_clk_gan`.`emr_client_program` inner join `wx_clk_gan`.`emr_discharge_reason` on `emr_discharge_reason_id` = `ecp_discharge_reason_id` where (`dch_name` like '%deceased%' or `dch_name` like '%death%') union all select `ecp_discharge_date`, `ecp_client_id` from `wx_clk_sen`.`emr_client_program` inner join `wx_clk_sen`.`emr_discharge_reason` on `emr_discharge_reason_id` = `ecp_discharge_reason_id` where (`dch_name` like '%deceased%' or `dch_name` like '%death%') union all select `ecp_discharge_date`, `ecp_client_id` from `wx_clk_co2`.`emr_client_program` inner join `wx_clk_co2`.`emr_discharge_reason` on `emr_discharge_reason_id` = `ecp_discharge_reason_id` where (`dch_name` like '%deceased%' or `dch_name` like '%death%')) as `dischargeReasonDeceased` where `ecp_client_id` = `emr_client_id`) as `5` from `wx_clk_pcs`.`emr_client` limit 5
SQL;

        $union = new UnionAll();
        $dbNames = ['wx_clk_io','wx_clk_fs','wx_clk_sil','wx_clk_opt','wx_clk_res','wx_clk_ccr','wx_clk_gan','wx_clk_sen','wx_clk_co2'];
        foreach($dbNames as $dbName) {
            $db = new Database($dbName);
            $union->push((new Select())->fields(new Column('ecp_discharge_date'), new Column('ecp_client_id'))->from(new Table('emr_client_program',$db)));
        }
        $minDischargeDate = (new Select())->fields(Agg::min(new Column('ecp_discharge_date')))->from(new SubQueryTable($union,new TableAlias('dischargeReasonDeceased')));

        $this->assertSimilar($sql,
            (new Select())
            ->from(new Table('emr_client',new Database('wx_clk_pcs')))
                ->fields(new FieldAs(new Column('emr_client_id'),new FieldAlias('0')))
                ->fields(new FieldAs(new Column('ecl_first_name'),new FieldAlias('1')))
                ->fields(new FieldAs(new Column('ecl_middle_name'),new FieldAlias('2')))
                ->fields(new FieldAs(new Column('ecl_last_name'),new FieldAlias('3')))
                ->fields(new FieldAs(new Column('ecl_birth_date'),new FieldAlias('4')))
                ->fields(new FieldAs($union,new FieldAlias('5')))
                ->limit(5)
            ->toSql($this->conn)
        );
    }
}
