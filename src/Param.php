<?php namespace QueryBuilder;

class Param implements IExpr {
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


    public function toSql(ISqlConnection $conn) {
        if(!$this->count) return '/* zero params */';
        if($this->name === null) {
            return $this->count == 1
                ? '?'
                : implode(', ',array_fill(0,$this->count,'?'));
        } else {
            if($this->count === 1) {
                return ':'.$this->name;
            }
            $sb = [];
            for($i=0; $i<$this->count; ++$i) {
                $sb[] = ':'.$this->name.$i;
            }
            return implode(', ',$sb);
        }
    }
}