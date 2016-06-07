<?php namespace QueryBuilder\Operator;

/**
 * @see https://en.wikipedia.org/wiki/Operator_associativity
 */
abstract class Associativity {
    /** Operations can be grouped arbitrarily */
    const ASSOCIATIVE = 1;
    /** Operations are grouped from the left */
    const LEFT_ASSOCIATIVE = 2;
    /** Operations are grouped from the right */
    const RIGHT_ASSOCIATIVE = 3;
    /** Operations can not be chained, often because the output type is incompatible with the input types */
    const NON_ASSOCIATIVE = 4;
}