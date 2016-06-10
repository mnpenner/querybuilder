<?php namespace QueryBuilder\Connections;

use QueryBuilder\Util;

abstract class AbstractMySqlConnection extends AbstractSqlConnection {

    public function getDateFormat() {
        return 'Y-m-d H:i:s';
    }

    abstract public function getCharset();

    public function id($name, array &$ctx) {
        return '`' . Util::mbStrReplace('`', '``', $name, $this->getCharset()) . '`';
    }

    public function escapeLikePattern($patt, $escapeChar = '\\') {
        if(mb_strlen($escapeChar, $this->getCharset()) !== 1) throw new \Exception('Escape character must be exactly one character');
        return Util::mbStrReplace([$escapeChar, '%', '_'], [$escapeChar . $escapeChar, $escapeChar . '%', $escapeChar . '_'], $patt, $this->getCharset());
    }
}