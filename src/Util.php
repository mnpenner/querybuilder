<?php namespace QueryBuilder;

abstract class Util {
    /**
     * Capitalizes and strips excess whitespace.
     *
     * @param string $word
     * @return string
     */
    public static function keyword($word) {
        return strtoupper(preg_replace('~[ \t\n\r\0\x0B\x0C]+~',' ',trim($word," \t\n\r\0\x0B\x0C")));
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

    public static function mb_str_replace($search, $replace, $subject, $encoding = 'auto') {
        if(!is_array($subject)) {
            $searches = is_array($search) ? array_values($search) : [$search];
            $replacements = is_array($replace) ? array_values($replace) : [$replace];
            $replacements = array_pad($replacements, count($searches), '');
            foreach($searches as $key => $search) {
                $replace = $replacements[$key];

                $searchLen = mb_strlen($search, $encoding);
                $replaceLen = mb_strlen($replace, $encoding);
                $offset = 0;

                while(($offset = mb_strpos($subject, $search, $offset, $encoding)) !== false) {
                    $subject = mb_substr($subject, 0, $offset, $encoding) . $replace . mb_substr($subject, $offset + $searchLen, null, $encoding);
                    $offset += $replaceLen;
                }
            }
        } else {
            foreach($subject as $key => $value) {
                $subject[$key] = self::mb_str_replace($search, $replace, $value, $encoding);
            }
        }
        return $subject;
    }
}