<?php
use QueryBuilder\Asterisk;
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
use QueryBuilder\Operator\Pipes;
use QueryBuilder\Operator\RShift;
use QueryBuilder\Operator\Sub;
use QueryBuilder\Order;
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

class MsSqlTest extends TestCase {
    /** @var \QueryBuilder\Connections\AbstractMsSqlConnection */
    protected $conn;

    protected function setUp() {
        $this->conn = new \QueryBuilder\Connections\FakeMsSqlConnection();
    }

    function testId() {
        $a = [];
        $this->assertSimilar('[select]',$this->conn->id('select',$a));
        $this->assertSimilar('[a`b]',$this->conn->id('a`b',$a));
        $this->assertSimilar('[c"d]',$this->conn->id('c"d',$a));
        $this->assertSimilar('[e[f]',$this->conn->id('e[f',$a));
        $this->assertSimilar('[g]]h]',$this->conn->id('g]h',$a));
    }

    function testEscapeLike() {
        $this->assertSame("\\foo[_]bar[%]", $this->conn->escapeLikePattern('\\foo_bar%'));
        $this->assertSame("[[]foo]", $this->conn->escapeLikePattern('[foo]'));
        $this->assertSame("!!foo", $this->conn->escapeLikePattern('!foo','!'));
//        $foo = new Column('foo');
//        $query = (new Select())->select($foo)->from(new Table('bar'))->where(new Like($foo,new Value($this->conn->escapeLikePattern('\\foo_bar%'))));
//        $this->assertSimilar("SELECT `foo` FROM `bar` WHERE `foo` LIKE '\\\\\\\\foo\\\\_bar\\\\%'", $this->conn->render($query));
    }
}
