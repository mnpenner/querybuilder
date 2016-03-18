<?php namespace QueryBuilder\Connections;
use QueryBuilder\Connections\AbstractMySqlConnection;
use QueryBuilder\Util;

/**
 * Does not require an actual MySQL connection.
 */
class FakeMySqlConnection extends AbstractMySqlConnection {
    /** @var bool Disable the use of the backslash character (“\”) as an escape character within strings. With this mode enabled, backslash becomes an ordinary character like any other. */
    protected $noBackslashEscapes;
    /** @var string */
    protected $charset;

    /**
     * @param string $charset            The character set used by the MySQL server. Must be set correctly, particularly if any of the following charsets are used: `big5`, `cp932`, `gb2312`, `gbk` or `sjis`. Otherwise, SQL injection is possible (see [this answer](http://stackoverflow.com/a/12118602/65387) and [this answer](http://stackoverflow.com/a/36082818/65387) for details).
     * @param bool $no_backslash_escapes Set to `true` if the MySQL server has [NO_BACKSLASH_ESCAPES](http://dev.mysql.com/doc/refman/5.7/en/sql-mode.html#sqlmode_no_backslash_escapes) enabled. Failing to do so will double up backslashes, causing your strings to be mangled.
     */
    function __construct($charset = 'utf8', $no_backslash_escapes = false) {
        $this->setNoBackslashEscapes($no_backslash_escapes);
        $this->setCharset($charset);
    }

    public function setCharset($charset) {
        $this->charset = strtolower($charset) === 'utf8mb4' ? 'utf8' : $charset;
    }

    public function setNoBackslashEscapes($enabled) {
        $this->noBackslashEscapes = $enabled;
    }

    protected function quoteString($string) {
        if($this->noBackslashEscapes) {
            return "'" . Util::mbStrReplace("'", "''", $string, $this->charset) . "'";
        } else {
            return "'" . Util::mbStrReplace(['\\', "'"], ['\\\\', "\\'"], $string, $this->charset) . "'";
        }
    }
}