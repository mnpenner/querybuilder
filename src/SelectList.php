<?php namespace QueryBuilder;

use QueryBuilder\Collections\Deque;
use QueryBuilder\Interfaces\IField;
use QueryBuilder\Interfaces\ISelectList;

class SelectList extends Deque implements ISelectList {
    public function append(IField ...$elements) {
        parent::append(...$elements);
    }

    public function prepend(IField ...$elements) {
        parent::prepend(...$elements);
    }
}