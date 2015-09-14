<?php namespace QueryBuilder\MySql\DataTypes\String;

/**
 * 16 MiB
 */
class MediumText extends AbstractText {

    protected function getName() {
        return 'MEDIUMTEXT';
    }
}