<?php namespace QueryBuilder\MySql\Keywords;

use QueryBuilder\ICharset;
use QueryBuilder\RawCharset;

// TODO: merge with RawCharset

abstract class Charset {
    /**
     * @return ICharset Big5 Traditional Chinese
     */
    public static function big5() {
        return new RawCharset('big5');
    }

    /**
     * @return ICharset DEC West European
     */
    public static function dec8() {
        return new RawCharset('dec8');
    }

    /**
     * @return ICharset DOS West European
     */
    public static function cp850() {
        return new RawCharset('cp850');
    }

    /**
     * @return ICharset HP West European
     */
    public static function hp8() {
        return new RawCharset('hp8');
    }

    /**
     * @return ICharset KOI8-R Relcom Russian
     */
    public static function koi8r() {
        return new RawCharset('koi8r');
    }

    /**
     * @return ICharset cp1252 West European
     */
    public static function latin1() {
        return new RawCharset('latin1');
    }

    /**
     * @return ICharset ISO 8859-2 Central European
     */
    public static function latin2() {
        return new RawCharset('latin2');
    }

    /**
     * @return ICharset 7bit Swedish
     */
    public static function swe7() {
        return new RawCharset('swe7');
    }

    /**
     * @return ICharset US ASCII
     */
    public static function ascii() {
        return new RawCharset('ascii');
    }

    /**
     * @return ICharset EUC-JP Japanese
     */
    public static function ujis() {
        return new RawCharset('ujis');
    }

    /**
     * @return ICharset Shift-JIS Japanese
     */
    public static function sjis() {
        return new RawCharset('sjis');
    }

    /**
     * @return ICharset ISO 8859-8 Hebrew
     */
    public static function hebrew() {
        return new RawCharset('hebrew');
    }

    /**
     * @return ICharset TIS620 Thai
     */
    public static function tis620() {
        return new RawCharset('tis620');
    }

    /**
     * @return ICharset EUC-KR Korean
     */
    public static function euckr() {
        return new RawCharset('euckr');
    }

    /**
     * @return ICharset KOI8-U Ukrainian
     */
    public static function koi8u() {
        return new RawCharset('koi8u');
    }

    /**
     * @return ICharset GB2312 Simplified Chinese
     */
    public static function gb2312() {
        return new RawCharset('gb2312');
    }

    /**
     * @return ICharset ISO 8859-7 Greek
     */
    public static function greek() {
        return new RawCharset('greek');
    }

    /**
     * @return ICharset Windows Central European
     */
    public static function cp1250() {
        return new RawCharset('cp1250');
    }

    /**
     * @return ICharset GBK Simplified Chinese
     */
    public static function gbk() {
        return new RawCharset('gbk');
    }

    /**
     * @return ICharset ISO 8859-9 Turkish
     */
    public static function latin5() {
        return new RawCharset('latin5');
    }

    /**
     * @return ICharset ARMSCII-8 Armenian
     */
    public static function armscii8() {
        return new RawCharset('armscii8');
    }

    /**
     * @return ICharset UTF-8 Unicode
     */
    public static function utf8() {
        return new RawCharset('utf8');
    }

    /**
     * @return ICharset UCS-2 Unicode
     */
    public static function ucs2() {
        return new RawCharset('ucs2');
    }

    /**
     * @return ICharset DOS Russian
     */
    public static function cp866() {
        return new RawCharset('cp866');
    }

    /**
     * @return ICharset DOS Kamenicky Czech-Slovak
     */
    public static function keybcs2() {
        return new RawCharset('keybcs2');
    }

    /**
     * @return ICharset Mac Central European
     */
    public static function macce() {
        return new RawCharset('macce');
    }

    /**
     * @return ICharset Mac West European
     */
    public static function macroman() {
        return new RawCharset('macroman');
    }

    /**
     * @return ICharset DOS Central European
     */
    public static function cp852() {
        return new RawCharset('cp852');
    }

    /**
     * @return ICharset ISO 8859-13 Baltic
     */
    public static function latin7() {
        return new RawCharset('latin7');
    }

    /**
     * @return ICharset UTF-8 Unicode
     */
    public static function utf8mb4() {
        return new RawCharset('utf8mb4');
    }

    /**
     * @return ICharset Windows Cyrillic
     */
    public static function cp1251() {
        return new RawCharset('cp1251');
    }

    /**
     * @return ICharset UTF-16 Unicode
     */
    public static function utf16() {
        return new RawCharset('utf16');
    }

    /**
     * @return ICharset UTF-16LE Unicode
     */
    public static function utf16le() {
        return new RawCharset('utf16le');
    }

    /**
     * @return ICharset Windows Arabic
     */
    public static function cp1256() {
        return new RawCharset('cp1256');
    }

    /**
     * @return ICharset Windows Baltic
     */
    public static function cp1257() {
        return new RawCharset('cp1257');
    }

    /**
     * @return ICharset UTF-32 Unicode
     */
    public static function utf32() {
        return new RawCharset('utf32');
    }

    /**
     * @return ICharset Binary pseudo charset
     */
    public static function binary() {
        return new RawCharset('binary');
    }

    /**
     * @return ICharset GEOSTD8 Georgian
     */
    public static function geostd8() {
        return new RawCharset('geostd8');
    }

    /**
     * @return ICharset SJIS for Windows Japanese
     */
    public static function cp932() {
        return new RawCharset('cp932');
    }

    /**
     * @return ICharset UJIS for Windows Japanese
     */
    public static function eucjpms() {
        return new RawCharset('eucjpms');
    }

}