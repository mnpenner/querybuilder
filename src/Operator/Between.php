<?php namespace QueryBuilder\Operator;

use QueryBuilder\Operator;
use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IOperator;
use QueryBuilder\Interfaces\ISqlConnection;

class Between extends Operator {
    /** @var IExpr */
    protected $value;
    /** @var IExpr */
    protected $low;
    /** @var IExpr */
    protected $high;

    function __construct(IExpr $value, IExpr $low, IExpr $high) {
        $this->value = $value;
        $this->low = $low;
        $this->high = $high;
    }

    public function getOperator() {
        return 'BETWEEN';
    }

    public function getPrecedence() {
        return 60;
    }

    public function isAssociative() {
        return false; // select 4 between (2 between 1 and 3) and 5
    }

    public function getAssociativity() {
        return Associativity::RIGHT_ASSOCIATIVE;
    }

    public function operandCount() {
        return 3;
    }

    public function toSql(ISqlConnection $conn) {
        $lowSql = $this->low instanceof IOperator ? $this->low->getSqlWrapped($conn, true) : $this->low->toSql($conn);
        $highSql = $this->high instanceof IOperator ? $this->high->getSqlWrapped($conn, true) : $this->high->toSql($conn);
        return $this->value->toSql($conn)." BETWEEN $lowSql AND $highSql";
    }
}

__halt_compiler();

> select 5 between 1 and 2 + 10
1 # i.e. select 5 between 1 and (2 + 10)

> select 1 between 1 and 2 between 2 and 2
1

> select (1 between 1 and 2) between 2 and 2
0

> select 1 between 1 and (2 between 2 and 2)
1

> select 1 between (1 between 2 and 3) and 4
1

> select 1 between 1 between 2 and 3 and 4
# syntax error
