<?php namespace QueryBuilder;

use QueryBuilder\Collections\Deque;
use QueryBuilder\Interfaces\IOrder;
use QueryBuilder\Interfaces\IOrderByList;

class OrderByList extends Deque implements IOrderByList {
    public function append(IOrder ...$elements) {
        parent::append(...$elements);
    }

    public function prepend(IOrder ...$elements) {
        parent::prepend(...$elements);
    }
}