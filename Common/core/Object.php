<?php

class Object
{
    const FETCH_ROW = "FETCH_ROW";
    const FETCH_ALL = "FETCH_ALL";

    public static $db;

    public static function factory($db)
    {
        static::$db = $db;
    }

    public function get($sql)
    {
        //print_r($this->db);
    }

    public function select($sql, $search)
    {
        $where = $this->_getPrepareWhereBySearch($search);

        $query = static::$db->query($sql.$where);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    private function _getPrepareWhereBySearch($search)
    {
        if (!$search) {
            return "";
        }
        $where = " WHERE ";
        foreach ($search as $name => $value) {
            $where.=$name.' = '.'"'.$value.'" AND ';
        }
        $where = substr($where, 0, -4);
        return $where;
    }

    public function search($sql, $search, $type = self::FETCH_ALL, $orderBy=false)
    {
    	$where = $this->_getPrepareWhereBySearch($search);
    	if ($orderBy) {
            $where .= $where." ".$orderBy;
        }
    	$query = static::$db->query($sql.$where);
    	
    	return $query->fetchAll(PDO::FETCH_ASSOC);
    }
	
    public function insert($table, $values)
    {
    	$sql = "INSERT INTO `".$table."` ";
    	$prepareSql = $this->_getPrepareByInsert($values);
    	$sql = $sql.$prepareSql;
    	
    	$stm = static::$db->prepare($sql);
    	//static::$db->beginTransaction();
    	
    	$stm->execute();
    	
    	//static::$db->commit();
    	return static::$db->lastInsertId();
    }
    
    public function update($table, $search, $values)
    {
    	//UPDATE Customers
// 		SET ContactName='Alfred Schmidt', City='Hamburg'
// 		WHERE CustomerName='Alfreds Futterkiste';
    	$sql = "UPDATE `".$table."` ";
    	$sql .= $this->_getPrepareForUpdate($values);
    	$sql .= $this->_getPrepareWhereBySearch($search);
    	
    	return static::$db->query($sql);
    }
    
    public function delete($table, $search)
    {
    	$sql = "DELETE FROM ".$table;
    	$where = $this->_getPrepareWhereBySearch($search);
    	
    	$sql = $sql.$where;
    	
    	static::$db->query($sql);
    	
    	return true;
    }
    
    private function _getPrepareForUpdate($values)
    {
    	$sql = "";
    	foreach ($values as $key => $item) {
    		$sql .= "`".$key."` = '".$item."',";
    	}
    	
    	$sql = rtrim($sql, ",");
    	
    	$sql = "SET ".$sql." ";
    	return $sql;
    }
    
    private function _getPrepareByInsert($values)
    {
    	$keys = array_keys($values);
    	$keysStr = "(`".implode("`, `", $keys)."`) ";
    	
    	$value = array_values($values);
    	$valueStr = "VALUES ('".implode("', '", $value)."')";
    	
    	return $keysStr.$valueStr;
    }
    
    
    private function _getPDOType($type)
    {
    }
}