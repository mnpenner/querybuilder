<?php namespace QueryBuilder\Interfaces;
use QueryBuilder\Interfaces\ISqlFrag;

/**
 * May be used in SELECT <fields>
 */
interface IField extends ISqlFrag {

    /**
     * @return IExpr
     */
    public function getExpr();
}