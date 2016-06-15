<?php namespace QueryBuilder\Interfaces;

/**
 * May be used in SELECT <fields>
 */
interface ISelectList extends \Traversable {

    public function append(IField ...$elements);
    public function prepend(IField ...$elements);
}