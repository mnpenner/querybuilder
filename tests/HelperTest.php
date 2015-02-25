<?php
use QueryBuilder\Asterisk;
use QueryBuilder\ColumnAlias;
use QueryBuilder\Column;
use QueryBuilder\Dual;
use QueryBuilder\AMySqlConnection;
use QueryBuilder\Node;
use QueryBuilder\RawExpr;
use QueryBuilder\Select;
use QueryBuilder\SubQuery;
use QueryBuilder\TableAlias;
use QueryBuilder\Table;
use function QueryBuilder\with;
use function QueryBuilder\copy;

class HelperTest extends PHPUnit_Framework_TestCase {
    /** @var AMySqlConnection */
    protected $mySql;

    protected function setUp() {
        $this->mySql = new \QueryBuilder\FakeMySqlConnection();
    }


    function testWith() {
        $selectAll = (new Select())->fields(Asterisk::value());
        $selectUsers = with(clone $selectAll)->from(new Table('users'));
        $selectPrograms = with(clone $selectAll)->from(new Table('programs'));

        $this->assertSame("SELECT * FROM `users`",$selectUsers->toSql($this->mySql));
        $this->assertSame("SELECT * FROM `programs`",$selectPrograms->toSql($this->mySql));
    }

    function testCopy() {
        $selectAll = (new Select())->fields(Asterisk::value());
        $selectUsers = copy($selectAll)->from(new Table('users'));
        $selectPrograms = copy($selectAll)->from(new Table('programs'));

        $this->assertSame("SELECT * FROM `users`",$selectUsers->toSql($this->mySql));
        $this->assertSame("SELECT * FROM `programs`",$selectPrograms->toSql($this->mySql));
    }
}
