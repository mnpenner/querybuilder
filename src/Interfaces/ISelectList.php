<?php namespace QueryBuilder\Interfaces;


interface ISelectList extends \Traversable {

    public function append(IField ...$elements);
}