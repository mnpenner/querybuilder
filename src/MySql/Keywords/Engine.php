<?php namespace QueryBuilder\MySql\Keywords;

use QueryBuilder\IEngine;
use QueryBuilder\RawEngine;

// TODO: merge with RawEngine

abstract class Engine {
    /**
     * CSV storage engine
     *
     * @return IEngine
     */
    public static function CSV() {
        return new RawEngine('CSV');
    }

    /**
     * Collection of identical MyISAM tables
     *
     * @return IEngine
     */
    public static function MRG_MyISAM() {
        return new RawEngine('MRG_MyISAM');
    }

    /**
     * MyISAM storage engine
     *
     * @return IEngine
     */
    public static function MyISAM() {
        return new RawEngine('MyISAM');
    }

    /**
     * Generated tables filled with sequential values
     *
     * @return IEngine
     */
    public static function SEQUENCE() {
        return new RawEngine('SEQUENCE');
    }

    /**
     * Hash based, stored in memory, useful for temporary tables
     *
     * @return IEngine
     */
    public static function MEMORY() {
        return new RawEngine('MEMORY');
    }

    /**
     * Performance Schema
     *
     * @return IEngine
     */
    public static function PERFORMANCE_SCHEMA() {
        return new RawEngine('PERFORMANCE_SCHEMA');
    }

    /**
     * Crash-safe tables with MyISAM heritage
     *
     * @return IEngine
     */
    public static function Aria() {
        return new RawEngine('Aria');
    }

    /**
     * Percona-XtraDB, Supports transactions, row-level locking, foreign keys and encryption for tables
     *
     * @return IEngine
     */
    public static function InnoDB() {
        return new RawEngine('InnoDB');
    }
}