<?php namespace QueryBuilder\MySql\DataTypes;

/**
 * 64 KiB
 */
class Text16 extends AbstractText {

    protected function getName() {
        return 'TEXT';
    }
}