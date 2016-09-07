<?php namespace QueryBuilder\Connections;

use QueryBuilder\Util;

abstract class AbstractMySqlConnection extends AbstractSqlConnection {

    public function getDateTimeFormat() {
        return 'Y-m-d H:i:s';
    }

    abstract public function getCharset();

    public function id($name, array &$ctx) {
        return '`' . Util::mbStrReplace('`', '``', $name, $this->getCharset()) . '`';
    }

    /**
     * Escapes wildcard characters (% and _) for use in a LIKE expression.
     *
     * @param string $patt LIKE pattern
     * @param string|null $escapeChar Escape character. Defaults to “\”
     * @param array $ctx
     * @return string
     * @throws \Exception
     */
    public function escapeLikePattern($patt, $escapeChar=null, array &$ctx=null) {
        $len = mb_strlen($escapeChar, $this->getCharset());
        if($len === 0) {
            $escapeChar = '\\';
        } else if($len !== 1) {
            throw new \Exception('Escape character must be exactly one character');
        }
//        return Util::mbStrReplace([$escapeChar, '%', '_'], [$escapeChar . $escapeChar, $escapeChar . '%', $escapeChar . '_'], $patt, $this->getCharset());
        return Util::mbStrReplace2([
            $escapeChar => $escapeChar . $escapeChar,
            '%' => $escapeChar . '%',
            '_' => $escapeChar . '_',
        ], $patt, $this->getCharset());
    }
}