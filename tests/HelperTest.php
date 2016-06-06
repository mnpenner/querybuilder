<?php
use QueryBuilder\Asterisk;
use QueryBuilder\Connections\AbstractMySqlConnection;
use QueryBuilder\Statements\Select;
use QueryBuilder\Table;
use function QueryBuilder\copy;
use function QueryBuilder\with;

class HelperTest extends TestCase {
    /** @var AbstractMySqlConnection */
    protected $mySql;

    protected function setUp() {
        $this->mySql = new \QueryBuilder\Connections\FakeMySqlConnection();
    }


    function testWith() {
        $selectAll = (new Select())->fields(new Asterisk);
        $selectUsers = with(clone $selectAll)->from(new Table('users'));
        $selectPrograms = with(clone $selectAll)->from(new Table('programs'));

        $this->assertSimilar("SELECT * FROM `users`",$selectUsers->toSql($this->mySql));
        $this->assertSimilar("SELECT * FROM `programs`",$selectPrograms->toSql($this->mySql));
    }

    function testCopy() {
        $selectAll = (new Select())->fields(new Asterisk);
        $selectUsers = copy($selectAll)->from(new Table('users'));
        $selectPrograms = copy($selectAll)->from(new Table('programs'));

        $this->assertSimilar("SELECT * FROM `users`",$selectUsers->toSql($this->mySql));
        $this->assertSimilar("SELECT * FROM `programs`",$selectPrograms->toSql($this->mySql));
    }
}
