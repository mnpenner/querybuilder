<?php namespace QueryBuilder\Connections;

use QueryBuilder\Util;

/**
 * Implements PDO-style parameter names. i.e. `?` and `:name`.
 */
trait PdoParamTrait  {

    /**
     * Create a parameter for use in a prepared query.
     *
     * @param string|null $name Parameter name. May be `null`.
     * @param array $ctx Not used
     * @return string
     */
    public function makeParam($name, array &$ctx) {
        if(strlen($name)) {
            Util::assertName($name);
            return ':'.$name;
        }
        return '?';
    }
}