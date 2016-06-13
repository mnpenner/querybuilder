<?php namespace QueryBuilder\Connections;
use QueryBuilder\Connections\AbstractMySqlConnection;

/**
 * A wrapper around the mysql_* functions.
 *
 * WARNING:
 * This extension is deprecated as of PHP 5.5.0, and will be removed in the future. Instead, the MysqliConnection or PdoMySqlConnection should be used.
 */
class MySqlLinkConnection extends AbstractMySqlConnection {
    /** @var resource The MySQL connection */
    protected $linkIdentifier;
    /** @var string */
    private $charset;

    /**
     * @param resource $linkIdentifier The MySQL connection.
     * @param string|null $charset Charset used by this connection. Must set correctly to avoid possible injection.
     */
    function __construct($linkIdentifier, $charset=null) {
        $this->linkIdentifier = $linkIdentifier;

        if(strlen($charset)) {
            $this->charset = $charset;
        } else {
            $result = mysql_query("SELECT CHARSET('')", $this->linkIdentifier);
            $this->charset = mysql_result($result, 0, 0);
        }
        if(strtolower($this->charset) === 'utf8mb4') {
            $this->charset = 'utf8';
        }
    }

    /**
     * Quotes a string for use in a query.
     *
     * CAUTION:
     * The character set must be set either at the server level, or with the API function mysql_set_charset() for it to affect this method. See the concepts section on character sets for more information.
     *
     * @param string $string The string to be quoted.
     * @param array &$ctx
     * @return string
     */
    protected function quoteString($string, array &$ctx) {
        return "'".mysql_real_escape_string($string, $this->linkIdentifier)."'";
    }

    public function getCharset() {
        return $this->charset;
    }

    /**
     * Not supported.
     *
     * @param string|null $name
     * @param array $ctx
     * @return string
     * @throws \Exception
     * @deprecated Not supported
     */
    public function makeParam($name, array &$ctx) {
        throw new \Exception("ext/mysql does not support prepared statements");
    }
}