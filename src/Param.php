<?php namespace QueryBuilder;

class Param implements IExpr {
    protected $name;

    /**
     * @param string|null $name
     * @throws \Exception
     */
    function __construct($name=null) {
        if($name !== null && !preg_match('~[a-zA-Z0-9_]+\z~A',$name)) {
            throw new \Exception("Invalid parameter name");
        }
        $this->name = $name;
    }


    public function toSql(ISqlConnection $conn) {
        return $this->name === null ? '?' : ':'.$this->name;
    }
}