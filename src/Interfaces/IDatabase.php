<?php namespace QueryBuilder\Interfaces;

use QueryBuilder\Interfaces\ISqlFrag;

interface IDatabase extends ISqlFrag {
    /**
     * Gets the database name.
     *
     * @return string
     */
    function getDatabaseName();
}