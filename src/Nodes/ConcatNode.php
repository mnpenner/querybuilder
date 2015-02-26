<?php namespace QueryBuilder\Nodes;

/**
 * Logical OR unless [PIPES_AS_CONCAT](http://dev.mysql.com/doc/refman/5.7/en/sql-mode.html#sqlmode_pipes_as_concat) is enabled, in which case this becomes a concatenation operator (same as `CONCAT()`) .
 */
class ConcatNode extends AbstractNode {
    public function getType() {
        return '||';
    }
}