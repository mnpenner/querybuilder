<?php namespace QueryBuilder\Interfaces;
use QueryBuilder\Interfaces\IValue;

/**
 * Represents a string literal.
 */
interface IString extends IValue {
}

// I don't know if this has any uses. I wanted to use it in some functions that *only* accept strings, such as GROUP_CONCAT (http://dev.mysql.com/doc/refman/5.7/en/group-by-functions.html#function_group-concat) but even that doesn't accept strings with collations.