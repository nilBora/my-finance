<?php

class ObjectPDO extends AbstractObject
{
    public function __construct($db)
    {
        parent::__construct($db);
    }
    
    public function select($sql, $search)
    {
        $where = $this->getPrepareWhereBySearch($search);

        $query = $this->db->query($sql.$where);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public function search($sql, $search, $type = self::FETCH_ALL, $orderBy=false)
    {
        $where = $this->getPrepareWhereBySearch($search);
        
        if ($orderBy) {
            $where .= $where." ".$orderBy;
        }
        $query =  $this->db->query($sql.$where);
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function insert($table, $values)
    {
        $sql = "INSERT INTO `".$table."` ";
        $prepareSql = $this->_getPrepareByInsert($values);
        $sql = $sql.$prepareSql;
        
        $stm = $this->db->prepare($sql);
        //static::$db->beginTransaction();
        
        $stm->execute();
        
        //static::$db->commit();
        return $this->db->lastInsertId();
    }
    
        public function update($table, $search, $values)
    {
        $sql = "UPDATE `".$table."` ";
        $sql .= $this->_getPrepareForUpdate($values);
        $sql .= $this->getPrepareWhereBySearch($search);
        
        return $this->db->query($sql);
    }
    
    public function delete($table, $search)
    {
        $sql = "DELETE FROM ".$table;
        $where = $this->getPrepareWhereBySearch($search);
        
        $sql = $sql.$where;
        
        $this->db->query($sql);
        
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
}
