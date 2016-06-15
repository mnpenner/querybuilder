<?php namespace QueryBuilder;

use QueryBuilder\Collections\Deque;
use QueryBuilder\Interfaces\IGroupByList;
use QueryBuilder\Interfaces\IOrder;

class GroupByList extends Deque implements IGroupByList {
    public function append(IOrder ...$elements) {
        parent::append(...$elements);
    }

    public function prepend(IOrder ...$elements) {
        parent::prepend(...$elements);
    }
}