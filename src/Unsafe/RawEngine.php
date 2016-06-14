<?php namespace QueryBuilder\Unsafe;

use QueryBuilder\Interfaces\IEngine;
use QueryBuilder\Unsafe\RawSql;
use QueryBuilder\Interfaces\ICharset;

class RawEngine extends RawSql implements IEngine {}