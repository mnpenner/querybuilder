<?php namespace QueryBuilder;

use QueryBuilder\Interfaces\IAliasOrColumn;
use QueryBuilder\Interfaces\IExpr;
use QueryBuilder\Interfaces\IField;
use QueryBuilder\Interfaces\IFieldAlias;
use QueryBuilder\Interfaces\ISqlConnection;

class Param implements IExpr {
    use ExprTrait;

    protected $name;
    protected $count;

    /**
     * @param string|null $name
     * @param int $count
     * @throws \Exception
     */
    function __construct($name=null, $count=1) {
        if($name !== null && !preg_match('~[a-zA-Z0-9_]+\z~A',$name)) {
            throw new \Exception("Invalid parameter name");
        }
        if($count < 0) throw new \Exception("Count cannot be negative");
        $this->name = $name;
        $this->count = $count;
    }

    /**
     * Returns an array suitable for use in an 'execute' function. Will need to be merged with other parameters.
     * 
     * e.g.
     *
     *     > $p1 = new Param;
     *     > $p2 = new Param('name');
     *     > $p3 = new Param(null, 3);
     *     > $p4 = new Param('count', 3);
     *     > $params = array_merge($p1->fill('foo'), $p2->fill('bar'), $p3->fill(['x','y','z']), $p4->fill([7,8,9]));
     *     [
     *         0 => 'foo'
     *         'name' => 'bar'
     *         1 => 'x'
     *         2 => 'y'
     *         3 => 'z'
     *         'count0' => 7
     *         'count1' => 8
     *         'count2' => 9
     *     ]
     * @param mixed $value
     * @return array
     * @throws \Exception
     */
    public function fill($value) {
        if(!$this->count) return [];
        if(is_array($value)) {
            if(count($value) !== $this->count) {
                throw new \Exception("Number of parameters does not match; got ".count($value).", expected ".$this->count);
            }
            if(strlen($this->name)) {
                $result = [];
                for ($i = 0; $i < $this->count; ++$i) {
                    $result[$this->name . $i] = $value[$i];
                }
                return $result;
            } else {
                return $value;
            }
        }
        if(strlen($this->name)) {
            return [$this->name => $value];
        } else {
            return [$value];
        }
    }

    public function _toSql(ISqlConnection $conn, array &$ctx) {
        if(!$this->count) return '/* zero params */';
        if(!strlen($this->name)) {
            $params = [];
            for($i=0; $i<$this->count; ++$i) {
                $params[] = $conn->makeParam(null, $ctx);
            }
            return implode(', ',$params);
        } else {
            $instId = spl_object_hash($this);
            if($this->count === 1) {
                if(isset($ctx[__CLASS__][$this->name]) && $ctx[__CLASS__][$this->name] !== $instId) {
                    throw new \Exception("Duplicate parameter name: $this->name");
                }
                $ctx[__CLASS__][$this->name] = $instId;
                return $conn->makeParam($this->name, $ctx);
            }
            $sb = [];
            for($i=0; $i<$this->count; ++$i) {
                $paramName = $this->name.$i;
                if(isset($ctx[__CLASS__][$paramName]) && $ctx[__CLASS__][$paramName] !== $instId) {
                    throw new \Exception("Duplicate parameter name: $paramName");
                }
                $ctx[__CLASS__][$this->name] = $instId;
                $sb[] = $conn->makeParam($paramName, $ctx);
            }
            return implode(', ',$sb);
        }
    }

    /**
     * @return IExpr
     */
    public function getExpr() {
        return $this;
    }
}