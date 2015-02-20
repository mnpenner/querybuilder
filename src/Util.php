<?php namespace QueryBuilder;

abstract class Util {
    public static function keyword($word) {
        return strtoupper(preg_replace('~[ \t\n\r\0\x0B\x0C]+~',' ',trim($word," \t\n\r\0\x0B\x0C")));
    }
}