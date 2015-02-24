<?php namespace QueryBuilder;

use PDO;

class PdoMySqlConnection extends AMySqlConnection {
    /** @var PDO */
    protected $pdo;

    function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Quotes a string for use in a query.
     *
     * CAUTION:
     * The character set must be set either on the server level, or within the database connection itself (depending on the driver) for it to affect this method. See the driver-specific documentation for more information.
     *
     * @param string $string The string to be quoted.
     * @param int $paramType Provides a data type hint for drivers that have alternate quoting styles.
     * @return string A quoted string that is theoretically safe to pass into an SQL statement. Returns FALSE if the driver does not support quoting in this way.
     */
    protected function quoteString($string, $paramType = PDO::PARAM_STR) {
        return $this->pdo->quote($string, $paramType);
    }
}