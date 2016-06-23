<?php
use QueryBuilder\Asterisk;
use QueryBuilder\Collections\Deque;
use QueryBuilder\Column;
use QueryBuilder\Connections\AbstractMySqlConnection;
use QueryBuilder\Database;
use QueryBuilder\Dual;
use QueryBuilder\FieldAlias;
use QueryBuilder\ExprAs;
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
use QueryBuilder\Operator\In;
use QueryBuilder\Operator\Is;
use QueryBuilder\Operator\IsNot;
use QueryBuilder\Operator\Like;
use QueryBuilder\Operator\Negate;
use QueryBuilder\Operator\Between;
use QueryBuilder\Operator\BitOr;
use QueryBuilder\Operator\Div;
use QueryBuilder\Operator\Equal;
use QueryBuilder\Operator\IntDiv;
use QueryBuilder\Operator\LessThan;
use QueryBuilder\Operator\LogicalAnd;
use QueryBuilder\Operator\LogicalOr;
use QueryBuilder\Operator\LogXor;
use QueryBuilder\Operator\LShift;
use QueryBuilder\Operator\Mod;
use QueryBuilder\Operator\Mult;
use QueryBuilder\Operator\Not;
use QueryBuilder\Operator\NotIn;
use QueryBuilder\Operator\NotLike;
use QueryBuilder\Operator\Pipes;
use QueryBuilder\Operator\RShift;
use QueryBuilder\Operator\Sub;
use QueryBuilder\Order;
use QueryBuilder\OrderByList;
use QueryBuilder\Param;
use QueryBuilder\Statements\Select;
use QueryBuilder\Statements\Union;
use QueryBuilder\Statements\UnionAll;
use QueryBuilder\StringLiteral;
use QueryBuilder\SelectTable;
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
        $a = [];
        $this->assertSimilar('`select`',$this->conn->id('select',$a));
        $this->assertSimilar('`a``b`',$this->conn->id('a`b',$a));
        $this->assertSimilar('`c"d`',$this->conn->id('c"d',$a));
    }

    function testColumnRef() {
        $this->assertSimilar('`column`',$this->conn->render(new Column('column')));
        $this->assertSimilar('`table`.`column`',$this->conn->render(new Column('column',new Table('table'))));
        $this->assertSimilar('`schema`.`table`.`column`',$this->conn->render(new Column('column',new Table('table',new Database('schema')))));
        $this->assertSimilar('`sch``ema`.`tab.le`.`col"umn`',$this->conn->render(new Column('col"umn',new Table('tab.le',new Database('sch`ema')))));
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

    function testParamNegativeCountException() {
        $this->setExpectedException(Exception::class);
        new Param(null,-1);
    }

    function testDuplicateParamException() {
        $select = (new Select())
            ->fields(new Param('foo'),new Param('bar'))
            ->from(new Table('baz'))
            ->setWhere(new Equal(new Column('foo'),new Param('foo')));
        $this->setExpectedException(Exception::class);
        $this->conn->render($select);
    }

    function testDuplicateParam() {
        $foo = new Param('foo');
        $select = (new Select())
            ->fields($foo,new Param('bar'))
            ->from(new Table('baz'))
            ->setWhere(new Equal(new Column('foo'), $foo));
        $this->assertSimilar("SELECT :foo, :bar FROM `baz` WHERE `foo` = :foo",$this->conn->render($select));
    }

    function testParamFill() {
        $p1 = new Param;
        $p2 = new Param('name');
        $p3 = new Param(null, 3);
        $p4 = new Param('count', 3);
        $select = (new Select())->fields($p1, $p2, $p3, $p4)->from(new Table('table'));
        
        $params = array_merge($p1->fill('foo'), $p2->fill('bar'), $p3->fill(['x','y','z']), $p4->fill([7,8,9]));
        $this->assertSame([
            'foo',
            'name' => 'bar',
            'x','y','z',
            'count0' => 7,
            'count1' => 8,
            'count2' => 9,
        ],$params);
    }

    function testValue() {
        $select = (new Select())->fields(new Value(null), new Value(1), new Value(3.14), new Value(new \DateTime('1999-12-31 23:59:59')));
        $this->assertSimilar("SELECT NULL, 1, 3.14, TIMESTAMP '1999-12-31 23:59:59'",$this->conn->render($select));
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
        $this->assertSimilar("SELECT DISTINCT HIGH_PRIORITY MAX_STATEMENT_TIME = 5 STRAIGHT_JOIN SQL_BUFFER_RESULT SQL_NO_CACHE SQL_CALC_FOUND_ROWS * FROM `t1`",$this->conn->render($select));

        $select = (new Select())->fields(new Asterisk)->from(new Table('t2'))->cache()->all();
        $this->assertSimilar("SELECT ALL SQL_CACHE * FROM `t2`",$this->conn->render($select));
    }

    function testJoinSubQuery() {
        $select = (new Select())
            ->from(new Table('t1'))
            ->fields(new Asterisk)
            ->innerJoin(new SelectTable(
                (new Select())
                    ->from(new Table('t2'))
                    ->fields(new Asterisk)
                ,new TableAlias('t2'))
            );

        $this->assertSimilar("SELECT * FROM `t1` INNER JOIN (SELECT * FROM `t2`) AS `t2`",$this->conn->render($select));
    }

    function testAsteriskNoError() {
        $this->conn->render((new Select())
            ->from(new Table('t1'))
            ->fields(new Asterisk, new Column('x')));
    }

    function testAsteriskError() {
        $this->setExpectedException(\Exception::class, "unqualified *");
        $this->conn->render((new Select())
            ->from(new Table('t1'))
            ->fields(new Column('x'),new Asterisk));
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
        $this->assertSimilar("SELECT * FROM `t1`",$this->conn->render($select)); // this test has to run on its own, otherwise it will generate a warning (see testAsteriskWarning)

        $table2 = new Table('t2',new Database('db'));
        $select = (new Select())
            ->from($table1)
            ->fields(new Asterisk($table1), new Asterisk($table2));

        $this->assertSimilar("SELECT `t1`.*, `db`.`t2`.* FROM `t1`",$this->conn->render($select));
    }

    function testLimit() {
        $select = (new Select())
            ->from(new Table('t1'))
            ->fields(new Asterisk);
        $this->assertSimilar("SELECT * FROM `t1` LIMIT 10",$this->conn->render($select->limit(10)));
        $this->assertSimilar("SELECT * FROM `t1` LIMIT 10 OFFSET 20",$this->conn->render($select->offset(20)));
        $this->assertSimilar("SELECT * FROM `t1` LIMIT 18446744073709551615 OFFSET 20",$this->conn->render($select->limit(null)));
    }

    function testUnion() {
        $select1 = (new Select())->from(new Table('t1'))->fields(new Column('c1'));
        $select2 = (new Select())->from(new Table('t2'))->fields(new Column('c2'));
        $select3 = (new Select())->from(new Table('t3'))->fields(new Column('c3'));
        $union = new Union();
        $union->push($select1);
        $union->push($select2);
        $this->assertSimilar("SELECT `c1` FROM `t1` UNION SELECT `c2` FROM `t2` UNION SELECT `c3` FROM `t3` LIMIT 50 OFFSET 100",$this->conn->render($union->copy()->limit(50)->offset(100)->push($select3)));
        $this->assertSimilar("SELECT `c1` FROM `t1` UNION SELECT `c2` FROM `t2`",$this->conn->render($union));

        $unionAll = new UnionAll();
        $unionAll->push($select1);
        $unionAll->push($select2);
        $this->assertSimilar("SELECT `c1` FROM `t1` UNION ALL SELECT `c2` FROM `t2` UNION ALL SELECT `c3` FROM `t3` LIMIT 50 OFFSET 100",$this->conn->render($unionAll->copy()->limit(50)->offset(100)->push($select3)));
        $this->assertSimilar("SELECT `c1` FROM `t1` UNION ALL SELECT `c2` FROM `t2`",$this->conn->render($unionAll));

        $countAlias = new FieldAlias('count');
        $unionCount = (new UnionAll(
            (new Select())->from(new Table('t1'))->fields(new ExprAs(Agg::countRows(),$countAlias)),
            (new Select())->from(new Table('t2'))->fields(Agg::countRows())
        ));
        $select = (new Select())->fields(Agg::sum($countAlias))->from(new SelectTable($unionCount,new TableAlias('t3')));

        $this->assertSimilar("SELECT SUM(`count`) FROM (SELECT COUNT(*) AS `count` FROM `t1` UNION ALL SELECT COUNT(*) FROM `t2`) AS `t3`",$this->conn->render($select),"total number of rows across multiple tables");

        //var_dump($unionCount->toSql($this->conn));
        //var_dump($select->toSql($this->conn));
    }

    function testOrderBy() {
        $select = (new Select())->fields(new Asterisk)->orderBy(new Value(2), new Value(3))->orderBy(new Value(4))->preOrderBy(new Value(1));
        $this->assertSimilar("SELECT * ORDER BY 1, 2, 3, 4",$this->conn->render($select));

        $alias = new FieldAlias('vegetable');
        $select = (new Select())->fields(new ExprAs(new Column('bacon'),$alias))->orderBy(new Order($alias,Order::DESC));
        $this->assertSimilar("SELECT `bacon` AS `vegetable` ORDER BY `vegetable` DESC",$this->conn->render($select));

        $select = (new Select())
            ->fields(new Column('college'), new Column('region'), new Column('seed'))
            ->from(new Table('tournament'))
            ->orderBy(new Value(2), new Value(3));
        $this->assertSimilar("SELECT `college`, `region`, `seed` FROM `tournament` ORDER BY 2, 3",$this->conn->render($select));
        $select->preOrderBy(new Value(1));
        $this->assertSimilar("SELECT `college`, `region`, `seed` FROM `tournament` ORDER BY 1, 2, 3",$this->conn->render($select));
        $select->setOrderBy(...new Deque([new Value('a'),new Value('b')]));
        $this->assertSimilar("SELECT `college`, `region`, `seed` FROM `tournament` ORDER BY 'a', 'b'",$this->conn->render($select));
    }

    function testGroupBy() {
        $a = new Column('a');
        $b = new Column('b');
        $select = (new Select())->fields($a,Agg::countNonNull($b))->from(new Table('test_table'))->groupBy($a);
        $this->assertSimilar("SELECT `a`, COUNT(`b`) FROM `test_table` GROUP BY `a`",$this->conn->render($select));

        $select = (new Select())->fields($a,Agg::countNonNull($b))->from(new Table('test_table'))->groupBy(new Order($a,Order::DESC));
        $this->assertSimilar("SELECT `a`, COUNT(`b`) FROM `test_table` GROUP BY `a` DESC",$this->conn->render($select));

        $select = (new Select())
            ->fields($a,Agg::countNonNull($b))
            ->from(new Table('test_table'))
            ->groupBy(new Order($a,Order::DESC),$b)
            ->orderBy(new Value(null));
        $this->assertSimilar("SELECT `a`, COUNT(`b`) FROM `test_table` GROUP BY `a` DESC, `b` ORDER BY NULL",$this->conn->render($select));
        
        $groupByList = new Deque([$a, new Order($b,Order::DESC)]);
        $select = (new Select())->fields(new Asterisk())->from(new Table('t'))->setGroupBy(...$groupByList);
        $this->assertSimilar("SELECT * FROM `t` GROUP BY `a`, `b` DESC",$this->conn->render($select));

        $select->preGroupBy(new Value(1));
        $this->assertSimilar("SELECT * FROM `t` GROUP BY 1, `a`, `b` DESC",$this->conn->render($select));
        $select->setGroupBy(...new Deque([new Order($a,Order::DESC),new Value('b')]));
        $this->assertSimilar("SELECT * FROM `t` GROUP BY `a` DESC, 'b'",$this->conn->render($select));
    }
    
    function testFields() {
        $a = new Value(1);
        $b = new Value(2);
        $c = new Value(3);
        $select = (new Select())->fields($a,$b);
        $this->assertSimilar("SELECT 1, 2",$this->conn->render($select));
        $select->fields($c);
        $this->assertSimilar("SELECT 1, 2, 3",$this->conn->render($select));
        $select->setFields(...new Deque([$b,$c]));
        $this->assertSimilar("SELECT 2, 3",$this->conn->render($select));
        $select->preFields($a);
        $this->assertSimilar("SELECT 1, 2, 3",$this->conn->render($select));
    }

    function testOperators() {
        $zero = new Value(0);
        $one = new Value(1);
        $two = new Value(2);
        $three = new Value(3);
        $four = new Value(4);
        $five = new Value(5);
        
        $this->assertSimilar("SELECT 1 + 2 * 3",$this->conn->render((new Select())->fields(new Add($one,new Mult($two, $three)))));
        $this->assertSimilar("SELECT 1 * (2 + 3)",$this->conn->render((new Select())->fields(new Mult($one,new Add($two, $three)))));
        $this->assertSimilar("SELECT 1 << 2 << 3",$this->conn->render((new Select())->fields(new LShift($one, $two, $three))));
        $this->assertSimilar("SELECT (1 << 2) + 3",$this->conn->render((new Select())->fields(new Add(new LShift($one, $two), $three))));
        $this->assertSimilar("SELECT 1 + 2 << 3",$this->conn->render((new Select())->fields(new LShift(new Add($one, $two), $three))));
        $this->assertSimilar("SELECT 1 << 2 << 3",$this->conn->render((new Select())->fields(new LShift(new LShift($one, $two), $three))));
        $this->assertSimilar("SELECT 1 << (2 << 3)",$this->conn->render((new Select())->fields(new LShift($one,new LShift($two, $three)))));
        $this->assertSimilar("SELECT 1 >> 2 << 3",$this->conn->render((new Select())->fields(new LShift(new RShift($one, $two), $three))));
        $this->assertSimilar("SELECT 1 << (2 >> 3)",$this->conn->render((new Select())->fields(new LShift($one,new RShift($two, $three)))));
        $this->assertSimilar("SELECT !(1 + 2)",$this->conn->render((new Select())->fields(new Negate(new Add($one, $two)))));
        $this->assertSimilar("SELECT NOT 1 + 2",$this->conn->render((new Select())->fields(new Not(new Add($one, $two))))); // same as NOT(1+2)
        $this->assertSimilar("SELECT !(NOT 0)",$this->conn->render((new Select())->fields(new Negate(new Not($zero)))));
        $this->assertSimilar("SELECT NOT !0",$this->conn->render((new Select())->fields(new Not(new Negate($zero)))));
        $this->assertSimilar("SELECT 1 + (NOT 0)",$this->conn->render((new Select())->fields(new Add($one,new Not($zero)))));
        $this->assertSimilar("SELECT 1 + !0",$this->conn->render((new Select())->fields(new Add($one,new Negate($zero)))));
        $this->assertSimilar("SELECT !(0 << 1)",$this->conn->render((new Select())->fields(new Negate(new LShift($zero,$one)))));
        $this->assertSimilar("SELECT NOT 0 << 1",$this->conn->render((new Select())->fields(new Not(new LShift($zero,$one)))));
        $this->assertSimilar("SELECT 1 + 2 + 3",$this->conn->render((new Select())->fields(new Add($one,new Add($two,$three)))));
        $this->assertSimilar("SELECT 1 - (2 - 3)",$this->conn->render((new Select())->fields(new Sub($one,new Sub($two,$three)))));
        $this->assertSimilar("SELECT 1 % (2 % 3)",$this->conn->render((new Select())->fields(new Mod($one,new Mod($two,$three)))));
        $this->assertSimilar("SELECT 1 * 2 * 3",$this->conn->render((new Select())->fields(new Mult($one,new Mult($two,$three)))));
        $this->assertSimilar("SELECT 1 / (2 / 3)",$this->conn->render((new Select())->fields(new Div($one,new Div($two,$three)))));
        $this->assertSimilar("SELECT 1 / 2 / 3",$this->conn->render((new Select())->fields(new Div(new Div($one,$two),$three))));
        $this->assertSimilar("SELECT 1 * (2 / 3)",$this->conn->render((new Select())->fields(new Mult($one,new Div($two,$three)))));
        $this->assertSimilar("SELECT 1 * 2 / 3",$this->conn->render((new Select())->fields(new Div(new Mult($one,$two),$three))));
        $this->assertSimilar("SELECT 1 / (2 * 3)",$this->conn->render((new Select())->fields(new Div($one,new Mult($two,$three)))));
        $this->assertSimilar("SELECT 1 DIV (2 DIV 3)",$this->conn->render((new Select())->fields(new IntDiv($one,new IntDiv($two,$three)))));
        $this->assertSimilar("SELECT 1 < (2 < 3)",$this->conn->render((new Select())->fields(new LessThan($one,new LessThan($two,$three)))));
        $this->assertSimilar("SELECT 4 BETWEEN (2 BETWEEN 1 AND 3) AND 5",$this->conn->render((new Select())->fields(new Between($four,new Between($two,$one,$three),$five))));
        $this->assertSimilar("SELECT 1 = (2 = 2)",$this->conn->render((new Select())->fields(new Equal($one,new Equal($two,$two)))));
        $this->assertSimilar("SELECT @a := @b := 3",$this->conn->render((new Select())->fields(new Assign(new UserVariable('a'),new Assign(new UserVariable('b'),$three)))));
        
        $this->assertSimilar("SELECT `x` IS NULL",$this->conn->render((new Select())->fields(new Is(new Column('x'),new Value(null)))));
        $this->assertSimilar("SELECT `x` IS NOT NULL",$this->conn->render((new Select())->fields(new IsNot(new Column('x'),new Value(null)))));
        $this->assertSimilar("SELECT `foo` LIKE 'bar%'",$this->conn->render((new Select())->fields(new Like(new Column('foo'),new Value('bar%')))));
        $this->assertSimilar("SELECT `foo` NOT LIKE '%bar'",$this->conn->render((new Select())->fields(new NotLike(new Column('foo'),new Value('%bar')))));
        $this->assertSimilar("SELECT `x` IN (1,2,3)",$this->conn->render((new Select())->fields(new In(new Column('x'),new Value([1,2,3])))));
        $this->assertSimilar("SELECT `x` NOT IN (4,5,6)",$this->conn->render((new Select())->fields(new NotIn(new Column('x'),new Value([4,5,6])))));
        $this->assertSimilar("SELECT `a` <= `b`",$this->conn->render((new Select())->fields(new \QueryBuilder\Operator\LTE(new Column('a'),new Column('b')))));
        $this->assertSimilar("SELECT `a` >= `b`",$this->conn->render((new Select())->fields(new \QueryBuilder\Operator\GTE(new Column('a'),new Column('b')))));
        $this->assertSimilar("SELECT `a` ^ `b`",$this->conn->render((new Select())->fields(new \QueryBuilder\Operator\BitXor(new Column('a'),new Column('b')))));
        $this->assertSimilar("SELECT `a` & `b`",$this->conn->render((new Select())->fields(new \QueryBuilder\Operator\BitAnd(new Column('a'),new Column('b')))));
        $this->assertSimilar("SELECT `a` | `b`",$this->conn->render((new Select())->fields(new \QueryBuilder\Operator\BitOr(new Column('a'),new Column('b')))));
        $this->assertSimilar("SELECT `a` % `b`",$this->conn->render((new Select())->fields(new \QueryBuilder\Operator\Mod(new Column('a'),new Column('b')))));
        $this->assertSimilar("SELECT -`a`",$this->conn->render((new Select())->fields(new \QueryBuilder\Operator\Negative(new Column('a')))));

        $select = (new Select())->fields(new LogicalAnd(new Value(0),new Value(1),new Value(2),new LogicalAnd(new Value(3),new Value(4),new LogicalOr(new Value(5),new Value(6)))));
        $this->assertSimilar("SELECT 0 AND 1 AND 2 AND 3 AND 4 AND (5 OR 6)",$this->conn->render($select));

        $select = (new Select())->fields(new Assign(new UserVariable('x'),new LogicalOr($zero,new LogXor($one, new LogicalAnd($two,new Not($three))))));
        $this->assertSimilar("SELECT @x := 0 OR 1 XOR 2 AND NOT 3",$this->conn->render($select));

        $select = (new Select())->fields(new LogicalAnd($two,new LogXor($zero,new LogicalOr($one, new Assign(new UserVariable('x'),new Not($three))))));
        $this->assertSimilar("SELECT 2 AND (0 XOR (1 OR (@x := NOT 3)))",$this->conn->render($select));

        $this->assertSimilar("SELECT '2008-12-31 23:59:59' + INTERVAL 1 SECOND",$this->conn->render((new Select())->fields(new Add(new Value('2008-12-31 23:59:59'),new Interval(new Value(1), Interval::SECOND())))));
        $this->assertSimilar("SELECT INTERVAL 1 DAY + '2008-12-31'",$this->conn->render((new Select())->fields(new Add(new Interval(new Value(1), Interval::DAY()),new Value('2008-12-31')))));
    }

    function testSelect() {
        $dual = new Dual;

        $select = (new Select())
            ->fields(new Asterisk)
            ->from(new Table('wx_user'));
        $this->assertSimilar("SELECT * FROM `wx_user`",$this->conn->render($select));

        $eafkDatabase = new Database('wx_eafk_dso');
        $clientTable = new Table('emr_client',$eafkDatabase);
        $clientAlias = new TableAlias('client');
        $select = (new Select())
            ->fields(new Column('ecl_name',$clientTable), new ExprAs(new Column('ecl_birth_date',$clientAlias),new FieldAlias('dob')))
            ->from(new TableAs(new Table('emr_client', $eafkDatabase), $clientAlias));
        $this->assertSimilar("SELECT `wx_eafk_dso`.`emr_client`.`ecl_name`, `client`.`ecl_birth_date` AS `dob` FROM `wx_eafk_dso`.`emr_client` AS `client`",$this->conn->render($select));

        $select = (new Select())
            ->fields(new Asterisk)
            ->from($dual);
        $this->assertSimilar("SELECT * FROM DUAL",$this->conn->render($select));



        $select = (new Select())
            ->fields(Agg::exists((new Select())
                ->fields(new Asterisk)
                ->from($dual)
                ->setWhere(new Value(0)))
            );
        $this->assertSimilar("SELECT EXISTS(SELECT * FROM DUAL WHERE 0)",$this->conn->render($select));




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
        $this->assertSimilar('SELECT ABS(2)',$this->conn->render((new Select())->fields(Math::abs($two))));
        $this->assertSimilar('SELECT ACOS(1)',$this->conn->render((new Select())->fields(Math::acos($one))));
        $this->assertSimilar('SELECT ATAN(2)',$this->conn->render((new Select())->fields(Math::atan($two))));
        $this->assertSimilar('SELECT ATAN(-2, 2)',$this->conn->render((new Select())->fields(Math::atan(new Value(-2), $two))));
        $this->assertSimilar('SELECT ATAN2(-2, 2)',$this->conn->render((new Select())->fields(Math::atan2(new Value(-2), $two))));
        $this->assertSimilar('SELECT CEILING(1.23)',$this->conn->render((new Select())->fields(Math::ceil(new Value(1.23)))));
        $this->assertSimilar("SELECT CONV('a', 16, 2)",$this->conn->render((new Select())->fields(Math::conv(new Value('a'), new Value(16), $two))));
        $this->assertSimilar("SELECT COS(1)",$this->conn->render((new Select())->fields(Math::cos($one))));
        $this->assertSimilar("SELECT COT(1)",$this->conn->render((new Select())->fields(Math::cot($one))));
        $this->assertSimilar("SELECT CRC32('MySQL')",$this->conn->render((new Select())->fields(Math::crc32(new Value('MySQL')))));
        $this->assertSimilar("SELECT DEGREES(1)",$this->conn->render((new Select())->fields(Math::degrees($one))));
        $this->assertSimilar("SELECT EXP(1)",$this->conn->render((new Select())->fields(Math::exp($one))));
        $this->assertSimilar("SELECT FLOOR(1)",$this->conn->render((new Select())->fields(Math::floor($one))));
        $this->assertSimilar("SELECT FORMAT(12332.123456, 4)",$this->conn->render((new Select())->fields(Math::format(new Value(12332.123456),new Value(4)))));
        $this->assertSimilar("SELECT FORMAT(12332.2,2,'de_DE')",$this->conn->render((new Select())->fields(Math::format(new Value(12332.2),new Value(2), new Value('de_DE')))));
        $this->assertSimilar("SELECT FORMAT(12332.2,2,'de_DE')",$this->conn->render((new Select())->fields(Math::format(new Value(12332.2),new Value(2), new Value('de_DE')))));
        $hexAbc = Math::hex(new Value('abc'));
        $this->assertSimilar("SELECT 0x616263, 0x616263, HEX('abc'), UNHEX(HEX('abc'))",$this->conn->render((new Select())->fields(
            new HexLiteral(0x616263), new HexLiteral('abc'), $hexAbc, Str::unhex($hexAbc)
        )));
        $this->assertSimilar("SELECT LN(2)",$this->conn->render((new Select())->fields(Math::ln($two))));
        $this->assertSimilar("SELECT LOG(2)",$this->conn->render((new Select())->fields(Math::log($two))));
        $this->assertSimilar("SELECT LOG(2, 1)",$this->conn->render((new Select())->fields(Math::log($two, $one))));
        $this->assertSimilar("SELECT LOG2(2)",$this->conn->render((new Select())->fields(Math::log2($two))));
        $this->assertSimilar("SELECT LOG10(2)",$this->conn->render((new Select())->fields(Math::log10($two))));
        $this->assertSimilar("SELECT MOD(234, 10)",$this->conn->render((new Select())->fields(Math::mod(new Value(234), new Value(10)))));
        $this->assertSimilar("SELECT MOD(29, 9)",$this->conn->render((new Select())->fields(Math::mod(new Value(29), new Value(9)))));
        $this->assertSimilar("SELECT MOD(34.5, 3)",$this->conn->render((new Select())->fields(Math::mod(new Value(34.5), new Value(3)))));
        $this->assertSimilar("SELECT PI()",$this->conn->render((new Select())->fields(Math::pi())));
        $this->assertSimilar("SELECT POW(2, 2)",$this->conn->render((new Select())->fields(Math::pow($two, $two))));
        $this->assertSimilar("SELECT RADIANS(90)",$this->conn->render((new Select())->fields(Math::radians(new Value(90)))));
        $this->assertSimilar("SELECT RAND(), RAND(3)",$this->conn->render((new Select())->fields(Math::rand(), Math::rand(new Value(3)))));
        $this->assertSimilar("SELECT FLOOR(7 + RAND() * (12 - 7))",$this->conn->render((new Select())->fields(Math::randInt(new Value(7), new Value(12)))));
        $this->assertSimilar("SELECT FLOOR(7 + RAND(3) * (12 - 7))",$this->conn->render((new Select())->fields(Math::randInt(new Value(7), new Value(12), new Value(3)))));
        $this->assertSimilar("SELECT ROUND(-1.23)",$this->conn->render((new Select())->fields(Math::round(new Value(-1.23)))));
        $this->assertSimilar("SELECT ROUND(1.298, 1)",$this->conn->render((new Select())->fields(Math::round(new Value(1.298), new Value(1)))));
        $this->assertSimilar("SELECT SIGN(2.5)",$this->conn->render((new Select())->fields(Math::sign(new Value(2.5)))));
        $this->assertSimilar("SELECT SIN(PI())",$this->conn->render((new Select())->fields(Math::sin(Math::pi()))));
        $this->assertSimilar("SELECT SQRT(4)",$this->conn->render((new Select())->fields(Math::sqrt(new Value(4)))));
        $this->assertSimilar("SELECT TAN(PI())",$this->conn->render((new Select())->fields(Math::tan(Math::pi()))));
        $this->assertSimilar("SELECT TRUNCATE(1.223,1)",$this->conn->render((new Select())->fields(Math::truncate(new Value(1.223), new Value(1)))));
    }

    function testStringFuncs() {
        $this->assertSimilar("SELECT CHAR(77,121,83,81,'76')",$this->conn->render((new Select())->fields(Str::char(new Value(77), new Value(121), new Value(83), new Value(81), new Value('76')))));
        $this->assertSimilar("SELECT CHAR(0x65 USING utf8)",$this->conn->render((new Select())->fields(Str::charUsing(Charset::utf8(), new HexLiteral(101)))));
        $this->assertSimilar("SELECT CHAR_LENGTH('Hello world')",$this->conn->render((new Select())->fields(Str::charLength(new Value('Hello world')))));
        $this->assertSimilar("SELECT CONCAT_WS(',','First name','Second name','Last Name')",$this->conn->render((new Select())->fields(Str::concatWS(new Value(','),new Value('First name'),new Value('Second name'),new Value('Last name')))));
        $this->assertSimilar("SELECT EXPORT_SET(5,'Y','N',',',4)",$this->conn->render((new Select())->fields(Str::exportSet(new Value(5), new Value('Y'), new Value('N'), new Value(','), new Value(4)))));
        $this->assertSimilar("SELECT FIELD('ej', 'Hej', 'ej', 'Heja', 'hej', 'foo')",$this->conn->render((new Select())->fields(Str::field(new Value('ej'),new Value('Hej'),new Value('ej'),new Value('Heja'),new Value('hej'),new Value('foo')))));
        $this->assertSimilar("SELECT MAKE_SET(1 | 4,'hello','nice','world')",$this->conn->render((new Select())->fields(
            Str::makeSet(new BitOr(new Value(1), new Value(4)), new Value('hello'), new Value('nice'), new Value('world'))
        )));

        $this->assertSimilar("SELECT TRIM('  bar   ')",$this->conn->render((new Select())->fields(Str::trim(new Value('  bar   ')))));
        $this->assertSimilar("SELECT TRIM(LEADING 'x' FROM 'xxxbarxxx')",$this->conn->render((new Select())->fields(Str::trimLeading(new Value('xxxbarxxx'),new Value('x')))));
        $this->assertSimilar("SELECT TRIM(BOTH 'x' FROM 'xxxbarxxx')",$this->conn->render((new Select())->fields(Str::trim(new Value('xxxbarxxx'),new Value('x')))));
        $this->assertSimilar("SELECT TRIM(TRAILING 'xyz' FROM 'barxxyz')",$this->conn->render((new Select())->fields(Str::trimTrailing(new Value('barxxyz'),new Value('xyz')))));

        $this->assertSimilar("SELECT WEIGHT_STRING(@s)",$this->conn->render((new Select())->fields(Str::weightString(new UserVariable('s')))));
        $this->assertSimilar("SELECT WEIGHT_STRING('ab' AS CHAR(4))",$this->conn->render((new Select())->fields(Str::weightString(new StringLiteral('ab'), 'CHAR(4)'))));
        $this->assertSimilar("SELECT WEIGHT_STRING(0x7FFF LEVEL 1 DESC REVERSE)",$this->conn->render((new Select())->fields(Str::weightString(new HexLiteral(0x7FFF), null, '1 DESC REVERSE'))));
        $this->assertSimilar("SELECT WEIGHT_STRING('xy' AS BINARY(8) LEVEL 1-3)",$this->conn->render((new Select())->fields(Str::weightString(new StringLiteral('xy'), 'BINARY(8)', '1-3'))));
        $this->assertSimilar("SELECT WEIGHT_STRING('x' LEVEL 2, 3, 5)",$this->conn->render((new Select())->fields(Str::weightString(new StringLiteral('x'), null, [2,3,5]))));
        $this->assertSimilar("SELECT WEIGHT_STRING('x' LEVEL 1 ASC, 2 DESC, 3 REVERSE)",$this->conn->render((new Select())->fields(Str::weightString(new StringLiteral('x'), null, ['1 ASC', '2 DESC', '3 REVERSE']))));

        $this->assertSimilar("SELECT CONCAT('My', 'S', 'QL')",$this->conn->render((new Select())->fields(Str::concat(new StringLiteral('My'),new StringLiteral('S'),new StringLiteral('QL')))));
        $this->assertSimilar("SELECT CONCAT('My', NULL, 'QL')",$this->conn->render((new Select())->fields(Str::concat(new StringLiteral('My'),new Value(null),new StringLiteral('QL')))));
        $this->assertSimilar("SELECT CONCAT(14.3)",$this->conn->render((new Select())->fields(Str::concat(new Value(14.3)))));
    }

    function testStringLiteral() {
        // see https://dev.mysql.com/doc/refman/5.7/en/string-literals.html
        $this->assertEquals("SELECT 'string'", $this->conn->render((new Select())->fields(new StringLiteral('string'))));
        $this->assertEquals("SELECT _latin1'string'", $this->conn->render((new Select())->fields(new StringLiteral('string', Charset::latin1()))));
        $this->assertEquals("SELECT _latin1'string' COLLATE latin1_danish_ci", $this->conn->render((new Select())->fields(new StringLiteral('string', Charset::latin1(), Collation::latin1_danish_ci()))));
    }

    function testAggregateFuncs() {
        $select = (new Select())
            ->fields(Agg::exists((new Select())
                ->from(new Dual)
                ->fields(new Asterisk)
                ->setWhere(new Value(0)))
            );
        $this->assertSimilar("SELECT EXISTS(SELECT * FROM DUAL WHERE 0)",$this->conn->render($select));
        $this->assertSimilar("SELECT SUM(`amount`)",$this->conn->render((new Select())->fields(Agg::sum(new Column('amount')))));
        $this->assertSimilar("SELECT SUM(DISTINCT `amount`)",$this->conn->render((new Select())->fields(Agg::sum(new Column('amount'),true))));
        $this->assertSimilar("SELECT COUNT(*)",$this->conn->render((new Select())->fields(Agg::countRows())));
        $this->assertSimilar("SELECT COUNT(`name`)",$this->conn->render((new Select())->fields(Agg::countNonNull(new Column('name')))));
        $this->assertSimilar("SELECT COUNT(DISTINCT `first_name`, `last_name`)",$this->conn->render((new Select())->fields(Agg::countDistinct(new Column('first_name'),new Column('last_name')))));

        $this->assertSimilar("
            SELECT `student_name`,
                GROUP_CONCAT(DISTINCT `test_score` ORDER BY `test_score` DESC SEPARATOR ' ')
                FROM `student`
                GROUP BY `student_name`
                ",
            $this->conn->render((new Select())
                ->fields(
                    new Column('student_name'),
                    Agg::groupConcat([new Column('test_score')],true,[new Order(new Column('test_score'),Order::DESC)],' ')
                )
                ->from(new Table('student'))
                ->groupBy(new Column('student_name'))
                ));
    }

    function testHex() {
        // https://dev.mysql.com/doc/refman/5.7/en/hexadecimal-literals.html
        $this->assertSimilar("SELECT 0x0a",$this->conn->render((new Select())->fields(new HexLiteral("0x0a",true))));
        $this->assertSimilar("SELECT 0xaaa",$this->conn->render((new Select())->fields(new HexLiteral("0xaaa",true))));
        $this->assertSimilar("SELECT X'4D7953514C'",$this->conn->render((new Select())->fields(new HexLiteral("X'4D7953514C'",true))));
        $this->assertSimilar("SELECT 0x5061756c",$this->conn->render((new Select())->fields(new HexLiteral("0x5061756c",true))));
        $this->assertSimilar("SELECT 0xacbd18db4cc2f85cedef654fccc4a4d8",$this->conn->render((new Select())->fields(new HexLiteral(md5('foo'),true))));
        $this->assertSimilar("SELECT 0xACBD18DB4CC2F85CEDEF654FCCC4A4D8",$this->conn->render((new Select())->fields(new HexLiteral(md5('foo',true),false))));
        $this->assertSimilar("SELECT 0xA",$this->conn->render((new Select())->fields(new HexLiteral(10))));
    }

    function testHexEx() {
        $this->setExpectedException(\Exception::class);
        new HexLiteral("X'4D7953514'",true); // For values written using X'val' or x'val' format, val must contain an even number of digits.
    }

    function testTimeFuncs() {
        $this->assertSimilar("SELECT CONVERT_TZ(DATE_ADD('1970-01-01', INTERVAL 567082800 SECOND),'UTC',@@session.time_zone)",$this->conn->render((new Select())->fields(\QueryBuilder\MySql\Functions\Time::unixToDateTime(new Value(567082800)))));
    }

    function testSuperQualified() {
        $tbl = new Table('tbl',new Database('db'));
        $this->assertSimilar("SELECT `db`.`tbl`.`col` FROM `db`.`tbl`",$this->conn->render((new Select())->fields($tbl->column('col'))->from($tbl)));
    }

    function testSelectExpr() {
        $this->assertSimilar("SELECT 1",$this->conn->render((new Select())->fields(new Value(1))));
        $this->assertSimilar("SELECT 1 + 2",$this->conn->render((new Select())->fields(new Add(new Value(1),new Value(2)))));
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
                    ->fields(new Column('ecp_discharge_date'), new Column('ecp_client_id'))->from($db->table('emr_client_program'))
                    ->innerJoin($db->table('emr_discharge_reason'),new Equal(new Column('emr_discharge_reason_id'),new Column('ecp_discharge_reason_id')))
                    ->setWhere(new LogicalOr(new Like(new Column('dch_name'), new Value('%deceased%')),new Like(new Column('dch_name'), new Value('%death%'))))
            );
        }
        $minDischargeDate = (new Select())
            ->fields(Agg::min(new Column('ecp_discharge_date')))
            ->from(new SelectTable($union,new TableAlias('dischargeReasonDeceased')))
            ->setWhere(new Equal(new Column('ecp_client_id'),new Column('emr_client_id')))
            ;

        $this->assertSimilar($sql,
            $this->conn->render((new Select())
            ->from(new Table('emr_client',new Database('wx_clk_pcs')))
                ->fields(new ExprAs(new Column('emr_client_id'),new FieldAlias('0')))
                ->fields(new ExprAs(new Column('ecl_first_name'),new FieldAlias('1')))
                ->fields(new ExprAs(new Column('ecl_middle_name'),new FieldAlias('2')))
                ->fields(new ExprAs(new Column('ecl_last_name'),new FieldAlias('3')))
                ->fields(new ExprAs(new Column('ecl_birth_date'),new FieldAlias('4')))
                ->fields(new ExprAs(new \QueryBuilder\SelectExpr($minDischargeDate),new FieldAlias('5')))
                ->limit(5)
            )
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

        $valueQuery = (new Select())->fields(Agg::sum(new Column('siv_value')))
            ->from(new Table('emr_stats_report'))
            ->leftJoin(new Table('emr_stats_item'),new Equal(new Column('sli_stats_report_id'),new Column('emr_stats_report_id')))
            ->leftJoin(new Table('emr_stats_item_value'),new Equal(new Column('siv_stats_item_id'),new Column('emr_stats_item_id')))
            ->leftJoin(new Table('emr_stats_field'),new Equal(new Column('siv_stats_field_id'),new Column('emr_stats_field_id')))
            ;

        $startDate = new Value(1420099200);
        $endDate = new Value(1451635200);
        $valueWhere = new LogicalAnd(new Equal(new Column('sli_client_id'),new Column('emr_client_id')),new Between(new Column('esr_date'), $startDate, $endDate),new Equal(new Column('esr_discipline_id'),new Column('emr_discipline_id')));

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
            ->fields(new ExprAs(new Column('ecl_file_no'), new FieldAlias('File No')))
            ->fields(new ExprAs(new Column('ecl_last_name'), new FieldAlias('Last Name')))
            ->fields(new ExprAs(new Column('ecl_first_name'), new FieldAlias('First Name')))
            ->fields(new ExprAs(new Column('epg_short_name'), new FieldAlias('Program')))
            ->fields(new ExprAs(new Column('ed_short_name'), new FieldAlias('Discipline')))
            ->fields(new ExprAs(new \QueryBuilder\SelectExpr($valueQuery->copy()->setWhere($valueWhere->copy()->push(new Equal(new Column('esf_short_name2'), new Value('AS'))))), $asTimeField))
            ->fields(new ExprAs(new \QueryBuilder\SelectExpr($valueQuery->copy()->setWhere($valueWhere->copy()->push(new Equal(new Column('esf_short_name2'), new Value('IC'))))), $icTimeField))
            ->fields(new ExprAs(new \QueryBuilder\SelectExpr($valueQuery->copy()->setWhere($valueWhere->copy()->push(new Equal(new Column('esf_short_name2'), new Value('INTV'))))), $intvTimeField));

        $attendance = new TableAlias('attendance');
        $intv_time = new TableAlias('intv_time');
        $sumGroupStatValues = (new Select())->from(new Table('emr_group_stats_report'))
            ->leftJoin(new TableAs(new Table('emr_group_stats_value'), $attendance),new LogicalAnd(new Equal($attendance->column('gsv_group_stats_report_id'), new Column('emr_group_stats_report_id')),new Equal($attendance->column('gsv_group_stats_field_id'), new Value(10))))
            ->leftJoin(new TableAs(new Table('emr_group_stats_value'), $intv_time),new LogicalAnd(new Equal($intv_time->column('gsv_group_stats_report_id'), new Column('emr_group_stats_report_id')),new Equal($intv_time->column('gsv_group_stats_field_id'), new Value(4))))
            ->leftJoin(new Table('emr_group_stats_field'),new Equal($intv_time->column('gsv_group_stats_field_id'),new Column('emr_group_stats_field_id')))
            ->fields(Agg::sum($intv_time->column('gsv_value')))
            ->setWhere(new LogicalAnd(new Equal($attendance->column('gsv_client_id'),new Column('emr_client_id')),new Between(new Column('gsr_date'), $startDate, $endDate)))
        ;

        $query->fields(new ExprAs(new \QueryBuilder\SelectExpr($sumGroupStatValues),new FieldAlias('GRP INTV')))
            ->fields(new ExprAs(new Column('ecl_diagnosis2'),new FieldAlias('Specific Diag')))
            ->fields(new ExprAs($pn1->column('epn_name'),new FieldAlias('Presenting Needs')))
            ->fields(new ExprAs($pn2->column('epn_name'),new FieldAlias('Sec. Presenting Needs')))
            ->setWhere(new LogicalAnd(
                new Equal(new Column('epg_short_name'),new Value('EIP')),
                new Equal(new Column('ed_short_name'),new Value('PT')),
                new LogicalOr(
                    new Equal(new Column('ecl_diagnosis2'),new Value('Torticollis')),
                    new Equal(new Column('ecl_diagnosis2'),new Value('Plagiocephaly')),
                    new Equal($pn1->column('epn_name'),new Value('Torticollis - Suspected')),
                    new Equal($pn1->column('epn_name'),new Value('Plagiocephaly - Suspected')),
                    new Equal($pn2->column('epn_name'),new Value('Torticollis - Suspected')),
                    new Equal($pn2->column('epn_name'),new Value('Plagiocephaly - Suspected'))
                )
            ))
            ->groupBy(new Column('emr_client_id'))
            ->setHaving(new LogicalOr(
                new GreaterThan($asTimeField,new Value(0)),
                new GreaterThan($icTimeField,new Value(0)),
                new GreaterThan($intvTimeField,new Value(0))
            ))
            ->orderBy(new Column('ecl_last_name'))
        ;

        $this->assertSimilar($sql, $this->conn->render($query));
    }

    function testEscapeLike() {
        $this->assertSame("\\\\foo\\_bar\\%", $this->conn->escapeLikePattern('\\foo_bar%'));
        $this->assertSame("\\foo\xf0\x9f\x90\xac_bar\xf0\x9f\x90\xac%", $this->conn->escapeLikePattern('\\foo_bar%',"\xf0\x9f\x90\xac"));
        $foo = new Column('foo');
        $query = (new Select())->fields($foo)->from(new Table('bar'))->setWhere(new Like($foo,new Value($this->conn->escapeLikePattern('\\foo_bar%'))));
        $this->assertSimilar("SELECT `foo` FROM `bar` WHERE `foo` LIKE '\\\\\\\\foo\\\\_bar\\\\%'", $this->conn->render($query));
    }
    
    function testWith() {
        $query = (new Select())->fields(new Column('ecl_first_name'),new Column('ecl_last_name'))->from(new Table('emr_client'))->setWhere(new \QueryBuilder\Operator\GTE(new Column('ecl_birth_date'),new Value(946713600)));
        $this->assertSimilar("SELECT `ecl_first_name`, `ecl_last_name` FROM `emr_client` WHERE `ecl_birth_date` >= 946713600", $this->conn->render($query));
        $query->with([__CLASS__, '_withPrograms']);
        $this->assertSimilar("
            SELECT `ecl_first_name`, `ecl_last_name`, `ecp_number` 
            FROM `emr_client` 
                LEFT JOIN `emr_client_program` ON `ecp_client_id`=`emr_client_id`
            WHERE `ecl_birth_date` >= 946713600 AND `ecp_discharge_date` != 0
            ", $this->conn->render($query));
    }
    
    public static function _withPrograms(Select $qb) {
        $qb->leftJoin(new Table('emr_client_program'),new Equal(new Column('ecp_client_id'), new Column('emr_client_id')));
        $qb->fields(new Column('ecp_number'));
        $qb->andWhere(new \QueryBuilder\Operator\NotEqual(new Column('ecp_discharge_date'), new Value(0)));
    }
}
