<?php namespace QueryBuilder\Interfaces;


interface IGroupByList extends \Traversable {

    public function append(IOrder ...$elements);
    public function prepend(IOrder ...$elements);
}