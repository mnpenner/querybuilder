<?php namespace QueryBuilder\MySql\DataTypes;

/**
 * 16 MiB
 */
class Text24 extends AbstractText {

    protected function getName() {
        return 'MEDIUMTEXT';
    }
}