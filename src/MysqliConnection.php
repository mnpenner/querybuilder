<?php namespace QueryBuilder;

use mysqli;

class MysqliConnection extends AMySqlConnection {
    /** @var mysqli */
    protected $mysqli;

    function __construct(mysqli $mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Quotes a string for use in a query, escaping special characters and taking into account the current charset of the connection.
     *
     * CAUTION:
     * The character set must be set either at the server level, or with the API function mysqli_set_charset() for it to affect this method. See the concepts section on character sets for more information.
     *
     * @param string $string The string to be quoted.
     *                       Characters encoded are NUL (ASCII 0), \n, \r, \, ', ", and Control-Z.
     * @return string
     */
    protected function quoteString($string) {
        return "'".$this->mysqli->real_escape_string($string)."'";
    }
}