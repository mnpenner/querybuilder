<?php namespace QueryBuilder\Interfaces;
use QueryBuilder\Interfaces\ISqlFrag;

/**
 * May be used in SELECT <fields>
 */
interface IFieldList extends ISqlFrag, \Countable, \Traversable {
    
}