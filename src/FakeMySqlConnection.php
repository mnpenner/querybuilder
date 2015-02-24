<?php namespace QueryBuilder;

/**
 * Does not require an actual MySQL connection.
 *
 * WARNING:
 * - This will double up backslashes if [NO_BACKSLASH_ESCAPES](http://dev.mysql.com/doc/refman/5.7/en/sql-mode.html#sqlmode_no_backslash_escapes) is enabled
 * - SQL injection is possible if the server character set is one of `big5`, `cp932`, `gb2312`, `bgk` or `sjis`; [explanation](http://stackoverflow.com/a/12118602/65387)
 */
class FakeMySqlConnection extends MySqlConnection {
    protected function quoteString($string) {
        // see http://dev.mysql.com/doc/refman/5.7/en/string-literals.html
        return "'" . str_replace(["'", '\\', "\0", "\t", "\n", "\r", "\x08", "\x1a"], ["''", '\\\\', '\\0', '\\t', '\\n', '\\r', '\\b', '\\Z'], $string) . "'";
    }
}