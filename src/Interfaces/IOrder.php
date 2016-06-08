<?php namespace QueryBuilder\Interfaces;
use QueryBuilder\Interfaces\IField;

/**
 * May be used in a ORDER BY clause
 */
interface IOrder extends IField { // FIXME: doesn't this mean that ORDER BYs can be used in the field list? e.g. SELECT 1 ASC
}