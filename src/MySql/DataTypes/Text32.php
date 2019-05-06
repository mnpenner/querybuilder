<?php namespace QueryBuilder\MySql\DataTypes;

/**
 * 4 GiB
 */
class Text32 extends AbstractText {

    protected function getName() {
        return 'LONGTEXT';
    }
}