<?php namespace QueryBuilder\MySql\DataTypes\String;

/**
 * 255 bytes
 */
class TinyText extends AbstractText {

    protected function getName() {
        return 'TINYTEXT';
    }
}