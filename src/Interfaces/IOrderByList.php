<?php namespace QueryBuilder\Interfaces;


interface IOrderByList extends \Traversable {

    public function append(IOrder ...$elements);
    public function prepend(IOrder ...$elements);
}