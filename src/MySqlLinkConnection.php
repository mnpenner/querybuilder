<?php namespace QueryBuilder;

/**
 * A wrapper around the mysql_* functions.
 *
 * WARNING:
 * This extension is deprecated as of PHP 5.5.0, and will be removed in the future. Instead, the MysqliConnection or PdoMySqlConnection should be used.
 */
class MySqlLinkConnection extends AMySqlConnection {
    /** @var resource The MySQL connection */
    protected $linkIdentifier;

    /**
     * @param resource $linkIdentifier The MySQL connection.
     */
    function __construct($linkIdentifier) {
        $this->linkIdentifier = $linkIdentifier;
    }

    /**
     * Quotes a string for use in a query.
     *
     * CAUTION:
     * The character set must be set either at the server level, or with the API function mysql_set_charset() for it to affect this method. See the concepts section on character sets for more information.
     *
     * @param string $string The string to be quoted.
     * @return string
     */
    protected function quoteString($string) {
        return "'".mysql_real_escape_string($string, $this->linkIdentifier)."'";
    }
}