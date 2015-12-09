<?php
namespace wxtest2;

require __DIR__.'/bootstrap.php';

use QueryBuilder\Connections\FakeMySqlConnection;
use QueryBuilder\Functions\Stmt;
use QueryBuilder\IField;
use QueryBuilder\ISqlConnection;
use QueryBuilder\ITable;

abstract class WX {

    public static function users($alias=null) {
        return new UsersTable('webenginex', $alias);
    }
}

abstract class Table implements ITable {
    private $dbname;
    private $alias;

    public function __construct($dbname, $alias=null) {
        $this->dbname = $dbname;
        $this->alias = $alias;
    }

    abstract protected function getName();

    public function toSql(ISqlConnection $conn) {
        $sql = $conn->id($this->dbname).'.'.$conn->id($this->getName());
        if(strlen($this->alias)) {
            $sql .= ' AS ' . $conn->quote($this->alias);
        }
        return $sql;
    }

    public function getId(ISqlConnection $conn) {
        if(strlen($this->alias)) {
            return $conn->id($this->alias);
        } else {
            return $conn->id($this->dbname).'.'.$conn->id($this->getName());
        }
    }
}

class UsersTable extends Table {

    protected function getName() {
        return 'wx_user';
    }

    public function name($alias = null) {
        return new Column($this, 'name', $alias);
    }

    public function username($alias = null) {
        return new Column($this, 'login', $alias);
    }

    public function password($alias = null) {
        return new Column($this, 'password', $alias);
    }
}

class Column implements IField {
    private $table;
    private $name;
    private $alias;

    public function __construct(Table $table, $name, $alias) {
        $this->table = $table;
        $this->name = $name;
        $this->alias = $alias;
    }

    public function toSql(ISqlConnection $conn) {
        $sql = $this->table->getId($conn).'.'.$conn->id($this->name);
        if(strlen($this->alias)) {
            $sql .= ' AS '.$conn->id($this->alias);
        }
        return $sql;
    }
}

$fakeSql = new FakeMySqlConnection();
echo Stmt::select()->from($c = WX::users('creator'), $e = WX::users())->fields($c->name(), $c->password('pwd'), $e->name())->toSql($fakeSql).PHP_EOL;