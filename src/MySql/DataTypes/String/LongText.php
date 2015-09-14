<?php namespace QueryBuilder\MySql\DataTypes\String;

/**
 * 4 GiB
 */
class LongText extends AbstractText {

    protected function getName() {
        return 'LONGTEXT';
    }
}