<?php namespace QueryBuilder;

use QueryBuilder\Collections\Deque;
use QueryBuilder\Interfaces\IField;

class SelectList extends Deque {
    public function append(IField ...$elements) {
        parent::append(...$elements);
    }

    public function prepend(IField ...$elements) {
        parent::prepend(...$elements);
    }
}