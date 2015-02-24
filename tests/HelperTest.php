<?php
use QueryBuilder\Asterisk;
use QueryBuilder\ColumnAlias;
use QueryBuilder\ColumnRef;
use QueryBuilder\Dual;
use QueryBuilder\AMySqlConnection;
use QueryBuilder\Node;
use QueryBuilder\RawExpr;
use QueryBuilder\SelectStmt;
use QueryBuilder\SubQuery;
use QueryBuilder\TableAlias;
use QueryBuilder\TableRef;
use function QueryBuilder\with;
use function QueryBuilder\copy;

class HelperTest extends PHPUnit_Framework_TestCase {
    /** @var AMySqlConnection */
    protected $mySql;

    protected function setUp() {
        $this->mySql = new \QueryBuilder\FakeMySqlConnection();
    }


    function testWith() {
        $selectAll = (new SelectStmt())->select(Asterisk::value());
        $selectUsers = with(clone $selectAll)->from(new TableRef('users'));
        $selectPrograms = with(clone $selectAll)->from(new TableRef('programs'));

        $this->assertSame("SELECT * FROM `users`",$selectUsers->toSql($this->mySql));
        $this->assertSame("SELECT * FROM `programs`",$selectPrograms->toSql($this->mySql));
    }

    function testCopy() {
        $selectAll = (new SelectStmt())->select(Asterisk::value());
        $selectUsers = copy($selectAll)->from(new TableRef('users'));
        $selectPrograms = copy($selectAll)->from(new TableRef('programs'));

        $this->assertSame("SELECT * FROM `users`",$selectUsers->toSql($this->mySql));
        $this->assertSame("SELECT * FROM `programs`",$selectPrograms->toSql($this->mySql));
    }
}
