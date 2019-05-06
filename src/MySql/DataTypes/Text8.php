<?php namespace QueryBuilder\MySql\DataTypes;

/**
 * 255 bytes
 */
class Text8 extends AbstractText {

    protected function getName() {
        return 'TINYTEXT';
    }
}