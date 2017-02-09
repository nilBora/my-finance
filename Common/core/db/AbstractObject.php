<?php

abstract class AbstractObject implements IObject
{
    protected $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
}
