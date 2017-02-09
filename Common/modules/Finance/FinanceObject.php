<?php

class FinanceObject extends Object
{
    private $_tableName = 'finances';

    public function add($values)
    {
        if (empty($values['cdate'])) {
            $values['cdate'] = date("Y-m-d");
        }
        $values['ctime'] = date("H:i:s");
        return $this->insert($this->_tableName, $values);
    }

    public function getByDate($search)
    {
        $sql = "SELECT cdate, SUM(cash) as cash FROM ".$this->_tableName;

        $groupBy = "GROUP BY cdate";

        return $this->search($sql, $search, Object::FETCH_ALL, $groupBy);
    }

    public function get($search)
    {
        $sql = "SELECT * FROM ".$this->_tableName;

        $orderBy = "ORDER BY cdate";

        return $this->search($sql, $search, Object::FETCH_ALL, $orderBy);
    }
}