<?php
namespace wxtest2;

require __DIR__.'/bootstrap.php';

use QueryBuilder\Connections\FakeMySqlConnection;
use QueryBuilder\Database;
use QueryBuilder\FieldAlias;
use QueryBuilder\Functions\Stmt;
use QueryBuilder\IDatabase;
use QueryBuilder\IField;
use QueryBuilder\IFieldAlias;
use QueryBuilder\ISqlConnection;
use QueryBuilder\ITable;
use QueryBuilder\ITableAlias;
use QueryBuilder\ITableAs;
use QueryBuilder\Operator\Equal;
use QueryBuilder\RawExpr;
use QueryBuilder\TableAlias;
use QueryBuilder\Value;

abstract class WX {

    public static function users($alias=null) {
        return new UsersTable(new Database('webenginex'), $alias);
    }
}

class WxSchema implements IDatabase {
    private $dbname;

    public function __construct($dbname) {
        $this->dbname = $dbname;
    }

    public function users($alias=null) {
        return new UsersTable($this, $alias);
    }

    public function toSql(ISqlConnection $conn) {
        return $conn->id($this->dbname);
    }
}

abstract class Table implements ITableAs {
    private $db;
    private $alias;

    public function __construct(IDatabase $db, $alias=null) {
        $this->db = $db;
        $this->alias = $alias;
    }

    abstract protected function getName();

    public function toSql(ISqlConnection $conn) {
        $sql = $this->db->toSql($conn).'.'.$conn->id($this->getName());
        if(strlen($this->alias)) {
            $sql .= ' AS ' . $conn->id($this->alias);
        }
        return $sql;
    }

    public function getAlias() {
        if(strlen($this->alias)) {
            return new TableAlias($this->alias);
        } else {
            return new \QueryBuilder\Table($this->getName(), $this->db);
        }
    }
}

class UsersTable extends Table {

    protected function getName() {
        return 'wx_user';
    }

    public function id($alias = null) {
        return new Column($this, 'user_id', $alias);
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

    public function type($alias = null) {
        return new Column($this, 'type', $alias);
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

    public function getId() {
//        return new RawExpr('ZZZZZ');
        if(strlen($this->alias)) {
            return new FieldAlias($this->alias);
        } else {
            return new \QueryBuilder\Column($this->name, $this->table);
        }
    }

    public function toSql(ISqlConnection $conn) {
        $sql = $this->table->getAlias()->toSql($conn).'.'.$conn->id($this->name);
        if(strlen($this->alias)) {
            $sql .= ' AS '.$conn->id($this->alias);
        }
        return $sql;
    }
}

$fakeSql = new FakeMySqlConnection();
//echo Stmt::select()->from($c = WX::users('creator'), $e = WX::users())->fields($c->name(), $c->password('pwd'), $e->name())->toSql($fakeSql).PHP_EOL;
$app = new WxSchema('wx_ncdcs_res');
$pcs = new WxSchema('wx_ncdcs_pcs');
echo Stmt::select()
    ->from($au = $app->users('app_user'))
    ->innerJoin($pu = $pcs->users('pcs_user'),
        $au->username()->getId()) /// FIXME: this is broken because the "Table" class can't implement both TableAs as Table (with and without the "AS")
//        new Equal($au->username()->getId(),$pu->username()->getId()))
    ->fields($au->type())
    ->where(new Equal($pu->id()->getId(), new Value(2006)))
    ->toSql($fakeSql).PHP_EOL;