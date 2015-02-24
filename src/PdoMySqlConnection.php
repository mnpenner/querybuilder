<?php namespace QueryBuilder;

use PDO;

class PdoMySqlConnection extends MySqlConnection {
    /** @var PDO */
    protected $pdo;

    function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    protected function quoteString($string) {
        return $this->pdo->query($string);
    }
}