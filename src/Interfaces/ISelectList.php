<?php namespace QueryBuilder\Interfaces;


interface ISelectList extends \Countable, \Traversable {

    public function append(IField ...$elements);

    public function prepend(IField ...$elements);
}