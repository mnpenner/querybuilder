<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\ISqlFrag;
use QueryBuilder\Interfaces\ISqlConnection;

abstract class Util {
    /**
     * Capitalizes and strips excess whitespace.
     *
     * @param string $word
     * @return string
     * @deprecated
     */
    public static function keyword($word) {
        // TODO: remove this function. users should never be allowed to supply their own keywords
        return $word === null ? '' : trim(preg_replace('~[^A-Z0-9_]+~',' ',strtoupper($word)),' ');
    }

    public static function assertName($name, $allow_dots=false) {
        $name_patt = '[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*';
        $patt = '~'.$name_patt;
        if($allow_dots) {
            $patt .= '(\.'.$name_patt.')*';
        }
        $patt .= '\z~A';
        if(!preg_match($patt,$name)) {
            throw new \Exception("Invalid name '$name'");
        }
    }

    /**
     * Determines if an array is "associative" (like a dictionary or hash map). True if at least one index is "out of place".
     *
     * @param array $arr
     * @return bool
     */
    public static function isAssoc(array $arr) {
        $i = 0;
        foreach($arr as $k => $v) {
            if($k !== $i) return true;
            ++$i;
        }
        return false;
    }

    /**
     * Returns the resource type and number.
     *
     * @param resource $resource
     * @return string
     */
    public static function resourceName($resource) {
        $name = get_resource_type($resource);
        if(preg_match('~(\d+)\z~', (string)$resource, $matches)) {
            $name .= ' #'.$matches[1];
        }
        return $name;
    }

    /**
     * Returns the class name or internal type of a variable.
     *
     * @param mixed $var Variable to check
     * @return string Type
     */
    public static function getType($var) {
        if(is_object($var)) return get_class($var);
        if(is_resource($var)) return self::resourceName($var);
        return gettype($var);
    }

    /**
     * Replace all occurrences of the search string with the replacement string. Multibyte safe.
     *
     * @param string|array $search The value being searched for, otherwise known as the needle. An array may be used to designate multiple needles.
     * @param string|array $replace The replacement value that replaces found search values. An array may be used to designate multiple replacements.
     * @param string|array $subject The string or array being searched and replaced on, otherwise known as the haystack.
     *                              If subject is an array, then the search and replace is performed with every entry of subject, and the return value is an array as well.
     * @param string $encoding The encoding parameter is the character encoding. If it is omitted, the internal character encoding value will be used.
     * @return array|string
     */
    public static function mbStrReplace($search, $replace, $subject, $encoding) {
        if(!is_array($subject)) {
            $searches = is_array($search) ? array_values($search) : [$search];
            $replacements = is_array($replace) ? array_values($replace) : [$replace];
            $replacements = array_pad($replacements, count($searches), '');
            foreach($searches as $key => $search) {
                $replace = $replacements[$key];
                $search_len = mb_strlen($search, $encoding);

                $sb = [];
                while(($offset = mb_strpos($subject, $search, 0, $encoding)) !== false) {
                    $sb[] = mb_substr($subject, 0, $offset, $encoding);
                    $subject = mb_substr($subject, $offset + $search_len, null, $encoding);
                }
                $sb[] = $subject;
                $subject = implode($replace, $sb);
            }
        } else {
            foreach($subject as $key => $value) {
                $subject[$key] = self::mbStrReplace($search, $replace, $value, $encoding);
            }
        }
        return $subject;
    }

    /**
     * Generates a cryptographically secure random string from the alphabet ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_
     *
     * @param $len String length
     * @return string
     * @deprecated openssl_random_pseudo_bytes sucks
     */
    public static function randStr($len) {
        if($len < 0) throw new \BadMethodCallException('len',"Length must be non-negative");
        return strtr(substr(base64_encode(openssl_random_pseudo_bytes(ceil($len * 3 / 4))), 0, $len), '+/', '-_');
    }

    /**
     * @param string $glue
     * @param string[]|ISqlFrag[] $tokens
     * @param ISqlConnection $conn
     * @param array &$ctx
     * @return string
     */
    public static function joinSql($glue = '', array $tokens, ISqlConnection $conn, array &$ctx) {
        return implode($glue, array_map(function ($tok) use ($conn, &$ctx) {
            if($tok instanceof ISqlFrag) {
                return $tok->_toSql($conn, $ctx);
            }
            if(is_string($tok)) {
                return $tok;
            }
            throw new \Exception("Unexpected token type: ".(is_object($tok)?get_class($tok):gettype($tok)));
        }, $tokens));
    }

    public static function joinIter($glue = ',', $iterable) {
        return self::isIterable($iterable) ? implode($glue, self::toArray($iterable)) : (string)$iterable;
    }

    /**
     * Checks if an object is foreachable.
     *
     * @param mixed $obj
     * @return bool
     */
    public static function isIterable($obj) {
        return is_array($obj) || $obj instanceof \Traversable;
    }

    /**
     * Copy the iterator into an array
     *
     * @param array|\Traversable $iter The iterator being copied.
     * @param bool $use_keys Whether to use the iterator element keys as index.
     * @return array
     */
    public static function toArray($iter, $use_keys=true) {
        return is_array($iter) ? $iter : iterator_to_array($iter, $use_keys);
    }

}