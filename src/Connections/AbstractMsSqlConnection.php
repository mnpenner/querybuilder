<?php namespace QueryBuilder\Connections;

use QueryBuilder\Util;

abstract class AbstractMsSqlConnection extends AbstractSqlConnection {

    public function getDateTimeFormat() {
        return 'Y-m-dTH:i:s.u';
    }

    abstract public function getCharset();

    public function id($name, array &$ctx) {
        return '[' . Util::mbStrReplace(']', ']]', $name, $this->getCharset()) . ']';
    }

    /**
     * @param string $patt LIKE pattern
     * @param null|string $escapeChar Additional character to escape
     * @param array $ctx
     * @return string
     * @throws \Exception
     */
    public function escapeLikePattern($patt, $escapeChar=null, array &$ctx=null) {
        $charset = $this->getCharset();
        $escapeLen = mb_strlen($escapeChar, $charset);
        if ($escapeLen) {
            if($escapeLen !== 1) throw new \Exception("If escape character is provided, it must be exactly one character");
            $search = [$escapeChar, '[', '%', '_'];
            $replace = [$escapeChar . $escapeChar, $escapeChar . '[', $escapeChar . '%', $escapeChar . '_'];
        } else {
            $search = ['[', '%', '_'];
            $replace = ['[[]', '[%]', '[_]'];
        }
        
        return Util::mbStrReplace($search, $replace, $patt, $charset);
    }
}

__halt_compiler();

select * from strings where c1 like '[\]foo[_]bar[%]'
