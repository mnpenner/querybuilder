<?php namespace QueryBuilder\Connections;

abstract class AbstractMySqlConnection extends AbstractSqlConnection {

    public function getDateFormat(){
        return 'Y-m-d H:i:s';
    }

}