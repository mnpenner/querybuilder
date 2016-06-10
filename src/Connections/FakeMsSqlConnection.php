<?php namespace QueryBuilder\Connections;
use QueryBuilder\Util;

/**
 * Does not require an actual MS SQL Server connection.
 */
class FakeMsSqlConnection extends AbstractMsSqlConnection {

    /** @var string */
    private $charset;


    function __construct($charset = 'utf8') {
        $this->charset = $charset;
    }

    public function getCharset() {
        return $this->charset;
    }

    protected function quoteString($string, array &$ctx) {
        return "'" . Util::mbStrReplace("'", "''", $string, $this->charset) . "'";
    }
}