<?php
use QueryBuilder\Asterisk;
use QueryBuilder\Connections\AbstractMySqlConnection;
use QueryBuilder\Statements\Select;
use QueryBuilder\Table;
use function QueryBuilder\copy;
use function QueryBuilder\with;

class HelperTest extends PHPUnit_Framework_TestCase {
    /** @var AbstractMySqlConnection */
    protected $mySql;

    protected function setUp() {
        $this->mySql = new \QueryBuilder\Connections\FakeMySqlConnection();
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
