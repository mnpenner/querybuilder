<?php namespace QueryBuilder\MySql\DataTypes\String;

/**
 * 64 KiB
 */
class Text extends AbstractText {

    protected function getName() {
        return 'TEXT';
    }
}