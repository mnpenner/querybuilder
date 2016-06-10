<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\IOperator;
use QueryBuilder\Interfaces\ISqlConnection;
use QueryBuilder\SqlFrag;

abstract class Operator extends SqlFrag implements IOperator {

    public function getSqlWrapped(ISqlConnection $conn, $needs_parens, array &$ctx) {
        $sql = $this->_toSql($conn,$ctx);
        return $needs_parens ? "($sql)" : $sql;
    }
}

__halt_compiler();

http://dev.mysql.com/doc/refman/5.7/en/operator-precedence.html

170 INTERVAL
160 BINARY, COLLATE
150 !
140 - (unary minus), ~ (unary bit inversion)
130 ^
120 *, /, DIV, %, MOD
110 -, +
100 <<, >>
90  &
80  |
70  = (comparison), <=>, >=, >, <=, <, <>, !=, IS, LIKE, REGEXP, IN
60  BETWEEN, CASE, WHEN, THEN, ELSE
50  NOT
40  AND, &&
30  XOR
20  OR, ||
10  = (assignment), :=
