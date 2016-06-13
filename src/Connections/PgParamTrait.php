<?php namespace QueryBuilder\Connections;

use QueryBuilder\Util;

/**
 * Implements Pg-style parameter names. i.e. `$1`
 */
trait PgParamTrait  {

    /**
     * Create a parameter for use in a prepared query.
     *
     * @param string|null $name Parameter name. May be `null`.
     * @param array $ctx Not used
     * @return string
     * @throws \Exception
     */
    public function makeParam($name, array &$ctx) {
        if(strlen($name)) {
            if(!preg_match('~[1-9]\d*\z~A',$name)) {
                throw new \Exception("PostgreSQL only supports natural number parameter names (starting from 1); got '$name'");
            }
            return '$'.$name;
        }
        if(isset($ctx[__CLASS__])) {
            ++$ctx[__CLASS__];
        } else {
            $ctx[__CLASS__] = 1;
        }
        return '$'.$ctx[__CLASS__];
    }
}