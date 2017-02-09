<?php

abstract class AbstractObject implements IObject
{
    protected $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    protected function getPrepareWhereBySearch($search)
    {
        if (!$search) {
            return "";
        }
        $where = " WHERE ";
        foreach ($search as $name => $value) {
            $where .= $name.' = '.'"'.$value.'" AND ';
        }
        $where = substr($where, 0, -4);
        return $where;
    }
}
