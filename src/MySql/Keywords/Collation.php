<?php namespace QueryBuilder\MySql\Keywords;

use QueryBuilder\Interfaces\ICollation;
use QueryBuilder\Unsafe\RawCollation;

// TODO: merge with RawCollation

abstract class Collation {

    /**
     * @return ICollation
     */
    public static function big5_chinese_ci() {
        return new RawCollation('big5_chinese_ci');
    }

    /**
     * @return ICollation
     */
    public static function big5_bin() {
        return new RawCollation('big5_bin');
    }

    /**
     * @return ICollation
     */
    public static function dec8_swedish_ci() {
        return new RawCollation('dec8_swedish_ci');
    }

    /**
     * @return ICollation
     */
    public static function dec8_bin() {
        return new RawCollation('dec8_bin');
    }

    /**
     * @return ICollation
     */
    public static function cp850_general_ci() {
        return new RawCollation('cp850_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function cp850_bin() {
        return new RawCollation('cp850_bin');
    }

    /**
     * @return ICollation
     */
    public static function hp8_english_ci() {
        return new RawCollation('hp8_english_ci');
    }

    /**
     * @return ICollation
     */
    public static function hp8_bin() {
        return new RawCollation('hp8_bin');
    }

    /**
     * @return ICollation
     */
    public static function koi8r_general_ci() {
        return new RawCollation('koi8r_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function koi8r_bin() {
        return new RawCollation('koi8r_bin');
    }

    /**
     * @return ICollation
     */
    public static function latin1_german1_ci() {
        return new RawCollation('latin1_german1_ci');
    }

    /**
     * @return ICollation
     */
    public static function latin1_swedish_ci() {
        return new RawCollation('latin1_swedish_ci');
    }

    /**
     * @return ICollation
     */
    public static function latin1_danish_ci() {
        return new RawCollation('latin1_danish_ci');
    }

    /**
     * @return ICollation
     */
    public static function latin1_german2_ci() {
        return new RawCollation('latin1_german2_ci');
    }

    /**
     * @return ICollation
     */
    public static function latin1_bin() {
        return new RawCollation('latin1_bin');
    }

    /**
     * @return ICollation
     */
    public static function latin1_general_ci() {
        return new RawCollation('latin1_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function latin1_general_cs() {
        return new RawCollation('latin1_general_cs');
    }

    /**
     * @return ICollation
     */
    public static function latin1_spanish_ci() {
        return new RawCollation('latin1_spanish_ci');
    }

    /**
     * @return ICollation
     */
    public static function latin2_czech_cs() {
        return new RawCollation('latin2_czech_cs');
    }

    /**
     * @return ICollation
     */
    public static function latin2_general_ci() {
        return new RawCollation('latin2_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function latin2_hungarian_ci() {
        return new RawCollation('latin2_hungarian_ci');
    }

    /**
     * @return ICollation
     */
    public static function latin2_croatian_ci() {
        return new RawCollation('latin2_croatian_ci');
    }

    /**
     * @return ICollation
     */
    public static function latin2_bin() {
        return new RawCollation('latin2_bin');
    }

    /**
     * @return ICollation
     */
    public static function swe7_swedish_ci() {
        return new RawCollation('swe7_swedish_ci');
    }

    /**
     * @return ICollation
     */
    public static function swe7_bin() {
        return new RawCollation('swe7_bin');
    }

    /**
     * @return ICollation
     */
    public static function ascii_general_ci() {
        return new RawCollation('ascii_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function ascii_bin() {
        return new RawCollation('ascii_bin');
    }

    /**
     * @return ICollation
     */
    public static function ujis_japanese_ci() {
        return new RawCollation('ujis_japanese_ci');
    }

    /**
     * @return ICollation
     */
    public static function ujis_bin() {
        return new RawCollation('ujis_bin');
    }

    /**
     * @return ICollation
     */
    public static function sjis_japanese_ci() {
        return new RawCollation('sjis_japanese_ci');
    }

    /**
     * @return ICollation
     */
    public static function sjis_bin() {
        return new RawCollation('sjis_bin');
    }

    /**
     * @return ICollation
     */
    public static function hebrew_general_ci() {
        return new RawCollation('hebrew_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function hebrew_bin() {
        return new RawCollation('hebrew_bin');
    }

    /**
     * @return ICollation
     */
    public static function tis620_thai_ci() {
        return new RawCollation('tis620_thai_ci');
    }

    /**
     * @return ICollation
     */
    public static function tis620_bin() {
        return new RawCollation('tis620_bin');
    }

    /**
     * @return ICollation
     */
    public static function euckr_korean_ci() {
        return new RawCollation('euckr_korean_ci');
    }

    /**
     * @return ICollation
     */
    public static function euckr_bin() {
        return new RawCollation('euckr_bin');
    }

    /**
     * @return ICollation
     */
    public static function koi8u_general_ci() {
        return new RawCollation('koi8u_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function koi8u_bin() {
        return new RawCollation('koi8u_bin');
    }

    /**
     * @return ICollation
     */
    public static function gb2312_chinese_ci() {
        return new RawCollation('gb2312_chinese_ci');
    }

    /**
     * @return ICollation
     */
    public static function gb2312_bin() {
        return new RawCollation('gb2312_bin');
    }

    /**
     * @return ICollation
     */
    public static function greek_general_ci() {
        return new RawCollation('greek_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function greek_bin() {
        return new RawCollation('greek_bin');
    }

    /**
     * @return ICollation
     */
    public static function cp1250_general_ci() {
        return new RawCollation('cp1250_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function cp1250_czech_cs() {
        return new RawCollation('cp1250_czech_cs');
    }

    /**
     * @return ICollation
     */
    public static function cp1250_croatian_ci() {
        return new RawCollation('cp1250_croatian_ci');
    }

    /**
     * @return ICollation
     */
    public static function cp1250_bin() {
        return new RawCollation('cp1250_bin');
    }

    /**
     * @return ICollation
     */
    public static function cp1250_polish_ci() {
        return new RawCollation('cp1250_polish_ci');
    }

    /**
     * @return ICollation
     */
    public static function gbk_chinese_ci() {
        return new RawCollation('gbk_chinese_ci');
    }

    /**
     * @return ICollation
     */
    public static function gbk_bin() {
        return new RawCollation('gbk_bin');
    }

    /**
     * @return ICollation
     */
    public static function latin5_turkish_ci() {
        return new RawCollation('latin5_turkish_ci');
    }

    /**
     * @return ICollation
     */
    public static function latin5_bin() {
        return new RawCollation('latin5_bin');
    }

    /**
     * @return ICollation
     */
    public static function armscii8_general_ci() {
        return new RawCollation('armscii8_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function armscii8_bin() {
        return new RawCollation('armscii8_bin');
    }

    /**
     * @return ICollation
     */
    public static function utf8_general_ci() {
        return new RawCollation('utf8_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_bin() {
        return new RawCollation('utf8_bin');
    }

    /**
     * @return ICollation
     */
    public static function utf8_unicode_ci() {
        return new RawCollation('utf8_unicode_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_icelandic_ci() {
        return new RawCollation('utf8_icelandic_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_latvian_ci() {
        return new RawCollation('utf8_latvian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_romanian_ci() {
        return new RawCollation('utf8_romanian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_slovenian_ci() {
        return new RawCollation('utf8_slovenian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_polish_ci() {
        return new RawCollation('utf8_polish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_estonian_ci() {
        return new RawCollation('utf8_estonian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_spanish_ci() {
        return new RawCollation('utf8_spanish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_swedish_ci() {
        return new RawCollation('utf8_swedish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_turkish_ci() {
        return new RawCollation('utf8_turkish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_czech_ci() {
        return new RawCollation('utf8_czech_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_danish_ci() {
        return new RawCollation('utf8_danish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_lithuanian_ci() {
        return new RawCollation('utf8_lithuanian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_slovak_ci() {
        return new RawCollation('utf8_slovak_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_spanish2_ci() {
        return new RawCollation('utf8_spanish2_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_roman_ci() {
        return new RawCollation('utf8_roman_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_persian_ci() {
        return new RawCollation('utf8_persian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_esperanto_ci() {
        return new RawCollation('utf8_esperanto_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_hungarian_ci() {
        return new RawCollation('utf8_hungarian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_sinhala_ci() {
        return new RawCollation('utf8_sinhala_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_german2_ci() {
        return new RawCollation('utf8_german2_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_croatian_mysql561_ci() {
        return new RawCollation('utf8_croatian_mysql561_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_unicode_520_ci() {
        return new RawCollation('utf8_unicode_520_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_vietnamese_ci() {
        return new RawCollation('utf8_vietnamese_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_general_mysql500_ci() {
        return new RawCollation('utf8_general_mysql500_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_croatian_ci() {
        return new RawCollation('utf8_croatian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8_myanmar_ci() {
        return new RawCollation('utf8_myanmar_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_general_ci() {
        return new RawCollation('ucs2_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_bin() {
        return new RawCollation('ucs2_bin');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_unicode_ci() {
        return new RawCollation('ucs2_unicode_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_icelandic_ci() {
        return new RawCollation('ucs2_icelandic_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_latvian_ci() {
        return new RawCollation('ucs2_latvian_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_romanian_ci() {
        return new RawCollation('ucs2_romanian_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_slovenian_ci() {
        return new RawCollation('ucs2_slovenian_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_polish_ci() {
        return new RawCollation('ucs2_polish_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_estonian_ci() {
        return new RawCollation('ucs2_estonian_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_spanish_ci() {
        return new RawCollation('ucs2_spanish_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_swedish_ci() {
        return new RawCollation('ucs2_swedish_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_turkish_ci() {
        return new RawCollation('ucs2_turkish_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_czech_ci() {
        return new RawCollation('ucs2_czech_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_danish_ci() {
        return new RawCollation('ucs2_danish_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_lithuanian_ci() {
        return new RawCollation('ucs2_lithuanian_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_slovak_ci() {
        return new RawCollation('ucs2_slovak_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_spanish2_ci() {
        return new RawCollation('ucs2_spanish2_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_roman_ci() {
        return new RawCollation('ucs2_roman_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_persian_ci() {
        return new RawCollation('ucs2_persian_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_esperanto_ci() {
        return new RawCollation('ucs2_esperanto_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_hungarian_ci() {
        return new RawCollation('ucs2_hungarian_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_sinhala_ci() {
        return new RawCollation('ucs2_sinhala_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_german2_ci() {
        return new RawCollation('ucs2_german2_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_croatian_mysql561_ci() {
        return new RawCollation('ucs2_croatian_mysql561_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_unicode_520_ci() {
        return new RawCollation('ucs2_unicode_520_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_vietnamese_ci() {
        return new RawCollation('ucs2_vietnamese_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_general_mysql500_ci() {
        return new RawCollation('ucs2_general_mysql500_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_croatian_ci() {
        return new RawCollation('ucs2_croatian_ci');
    }

    /**
     * @return ICollation
     */
    public static function ucs2_myanmar_ci() {
        return new RawCollation('ucs2_myanmar_ci');
    }

    /**
     * @return ICollation
     */
    public static function cp866_general_ci() {
        return new RawCollation('cp866_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function cp866_bin() {
        return new RawCollation('cp866_bin');
    }

    /**
     * @return ICollation
     */
    public static function keybcs2_general_ci() {
        return new RawCollation('keybcs2_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function keybcs2_bin() {
        return new RawCollation('keybcs2_bin');
    }

    /**
     * @return ICollation
     */
    public static function macce_general_ci() {
        return new RawCollation('macce_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function macce_bin() {
        return new RawCollation('macce_bin');
    }

    /**
     * @return ICollation
     */
    public static function macroman_general_ci() {
        return new RawCollation('macroman_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function macroman_bin() {
        return new RawCollation('macroman_bin');
    }

    /**
     * @return ICollation
     */
    public static function cp852_general_ci() {
        return new RawCollation('cp852_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function cp852_bin() {
        return new RawCollation('cp852_bin');
    }

    /**
     * @return ICollation
     */
    public static function latin7_estonian_cs() {
        return new RawCollation('latin7_estonian_cs');
    }

    /**
     * @return ICollation
     */
    public static function latin7_general_ci() {
        return new RawCollation('latin7_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function latin7_general_cs() {
        return new RawCollation('latin7_general_cs');
    }

    /**
     * @return ICollation
     */
    public static function latin7_bin() {
        return new RawCollation('latin7_bin');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_general_ci() {
        return new RawCollation('utf8mb4_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_bin() {
        return new RawCollation('utf8mb4_bin');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_unicode_ci() {
        return new RawCollation('utf8mb4_unicode_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_icelandic_ci() {
        return new RawCollation('utf8mb4_icelandic_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_latvian_ci() {
        return new RawCollation('utf8mb4_latvian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_romanian_ci() {
        return new RawCollation('utf8mb4_romanian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_slovenian_ci() {
        return new RawCollation('utf8mb4_slovenian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_polish_ci() {
        return new RawCollation('utf8mb4_polish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_estonian_ci() {
        return new RawCollation('utf8mb4_estonian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_spanish_ci() {
        return new RawCollation('utf8mb4_spanish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_swedish_ci() {
        return new RawCollation('utf8mb4_swedish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_turkish_ci() {
        return new RawCollation('utf8mb4_turkish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_czech_ci() {
        return new RawCollation('utf8mb4_czech_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_danish_ci() {
        return new RawCollation('utf8mb4_danish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_lithuanian_ci() {
        return new RawCollation('utf8mb4_lithuanian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_slovak_ci() {
        return new RawCollation('utf8mb4_slovak_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_spanish2_ci() {
        return new RawCollation('utf8mb4_spanish2_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_roman_ci() {
        return new RawCollation('utf8mb4_roman_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_persian_ci() {
        return new RawCollation('utf8mb4_persian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_esperanto_ci() {
        return new RawCollation('utf8mb4_esperanto_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_hungarian_ci() {
        return new RawCollation('utf8mb4_hungarian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_sinhala_ci() {
        return new RawCollation('utf8mb4_sinhala_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_german2_ci() {
        return new RawCollation('utf8mb4_german2_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_croatian_mysql561_ci() {
        return new RawCollation('utf8mb4_croatian_mysql561_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_unicode_520_ci() {
        return new RawCollation('utf8mb4_unicode_520_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_vietnamese_ci() {
        return new RawCollation('utf8mb4_vietnamese_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_croatian_ci() {
        return new RawCollation('utf8mb4_croatian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf8mb4_myanmar_ci() {
        return new RawCollation('utf8mb4_myanmar_ci');
    }

    /**
     * @return ICollation
     */
    public static function cp1251_bulgarian_ci() {
        return new RawCollation('cp1251_bulgarian_ci');
    }

    /**
     * @return ICollation
     */
    public static function cp1251_ukrainian_ci() {
        return new RawCollation('cp1251_ukrainian_ci');
    }

    /**
     * @return ICollation
     */
    public static function cp1251_bin() {
        return new RawCollation('cp1251_bin');
    }

    /**
     * @return ICollation
     */
    public static function cp1251_general_ci() {
        return new RawCollation('cp1251_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function cp1251_general_cs() {
        return new RawCollation('cp1251_general_cs');
    }

    /**
     * @return ICollation
     */
    public static function utf16_general_ci() {
        return new RawCollation('utf16_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_bin() {
        return new RawCollation('utf16_bin');
    }

    /**
     * @return ICollation
     */
    public static function utf16_unicode_ci() {
        return new RawCollation('utf16_unicode_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_icelandic_ci() {
        return new RawCollation('utf16_icelandic_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_latvian_ci() {
        return new RawCollation('utf16_latvian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_romanian_ci() {
        return new RawCollation('utf16_romanian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_slovenian_ci() {
        return new RawCollation('utf16_slovenian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_polish_ci() {
        return new RawCollation('utf16_polish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_estonian_ci() {
        return new RawCollation('utf16_estonian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_spanish_ci() {
        return new RawCollation('utf16_spanish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_swedish_ci() {
        return new RawCollation('utf16_swedish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_turkish_ci() {
        return new RawCollation('utf16_turkish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_czech_ci() {
        return new RawCollation('utf16_czech_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_danish_ci() {
        return new RawCollation('utf16_danish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_lithuanian_ci() {
        return new RawCollation('utf16_lithuanian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_slovak_ci() {
        return new RawCollation('utf16_slovak_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_spanish2_ci() {
        return new RawCollation('utf16_spanish2_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_roman_ci() {
        return new RawCollation('utf16_roman_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_persian_ci() {
        return new RawCollation('utf16_persian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_esperanto_ci() {
        return new RawCollation('utf16_esperanto_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_hungarian_ci() {
        return new RawCollation('utf16_hungarian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_sinhala_ci() {
        return new RawCollation('utf16_sinhala_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_german2_ci() {
        return new RawCollation('utf16_german2_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_croatian_mysql561_ci() {
        return new RawCollation('utf16_croatian_mysql561_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_unicode_520_ci() {
        return new RawCollation('utf16_unicode_520_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_vietnamese_ci() {
        return new RawCollation('utf16_vietnamese_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_croatian_ci() {
        return new RawCollation('utf16_croatian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16_myanmar_ci() {
        return new RawCollation('utf16_myanmar_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16le_general_ci() {
        return new RawCollation('utf16le_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf16le_bin() {
        return new RawCollation('utf16le_bin');
    }

    /**
     * @return ICollation
     */
    public static function cp1256_general_ci() {
        return new RawCollation('cp1256_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function cp1256_bin() {
        return new RawCollation('cp1256_bin');
    }

    /**
     * @return ICollation
     */
    public static function cp1257_lithuanian_ci() {
        return new RawCollation('cp1257_lithuanian_ci');
    }

    /**
     * @return ICollation
     */
    public static function cp1257_bin() {
        return new RawCollation('cp1257_bin');
    }

    /**
     * @return ICollation
     */
    public static function cp1257_general_ci() {
        return new RawCollation('cp1257_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_general_ci() {
        return new RawCollation('utf32_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_bin() {
        return new RawCollation('utf32_bin');
    }

    /**
     * @return ICollation
     */
    public static function utf32_unicode_ci() {
        return new RawCollation('utf32_unicode_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_icelandic_ci() {
        return new RawCollation('utf32_icelandic_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_latvian_ci() {
        return new RawCollation('utf32_latvian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_romanian_ci() {
        return new RawCollation('utf32_romanian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_slovenian_ci() {
        return new RawCollation('utf32_slovenian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_polish_ci() {
        return new RawCollation('utf32_polish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_estonian_ci() {
        return new RawCollation('utf32_estonian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_spanish_ci() {
        return new RawCollation('utf32_spanish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_swedish_ci() {
        return new RawCollation('utf32_swedish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_turkish_ci() {
        return new RawCollation('utf32_turkish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_czech_ci() {
        return new RawCollation('utf32_czech_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_danish_ci() {
        return new RawCollation('utf32_danish_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_lithuanian_ci() {
        return new RawCollation('utf32_lithuanian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_slovak_ci() {
        return new RawCollation('utf32_slovak_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_spanish2_ci() {
        return new RawCollation('utf32_spanish2_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_roman_ci() {
        return new RawCollation('utf32_roman_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_persian_ci() {
        return new RawCollation('utf32_persian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_esperanto_ci() {
        return new RawCollation('utf32_esperanto_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_hungarian_ci() {
        return new RawCollation('utf32_hungarian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_sinhala_ci() {
        return new RawCollation('utf32_sinhala_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_german2_ci() {
        return new RawCollation('utf32_german2_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_croatian_mysql561_ci() {
        return new RawCollation('utf32_croatian_mysql561_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_unicode_520_ci() {
        return new RawCollation('utf32_unicode_520_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_vietnamese_ci() {
        return new RawCollation('utf32_vietnamese_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_croatian_ci() {
        return new RawCollation('utf32_croatian_ci');
    }

    /**
     * @return ICollation
     */
    public static function utf32_myanmar_ci() {
        return new RawCollation('utf32_myanmar_ci');
    }

    /**
     * @return ICollation
     */
    public static function binary() {
        return new RawCollation('binary');
    }

    /**
     * @return ICollation
     */
    public static function geostd8_general_ci() {
        return new RawCollation('geostd8_general_ci');
    }

    /**
     * @return ICollation
     */
    public static function geostd8_bin() {
        return new RawCollation('geostd8_bin');
    }

    /**
     * @return ICollation
     */
    public static function cp932_japanese_ci() {
        return new RawCollation('cp932_japanese_ci');
    }

    /**
     * @return ICollation
     */
    public static function cp932_bin() {
        return new RawCollation('cp932_bin');
    }

    /**
     * @return ICollation
     */
    public static function eucjpms_japanese_ci() {
        return new RawCollation('eucjpms_japanese_ci');
    }

    /**
     * @return ICollation
     */
    public static function eucjpms_bin() {
        return new RawCollation('eucjpms_bin');
    }
}