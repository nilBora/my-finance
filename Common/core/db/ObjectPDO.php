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
        $queryString = $sql.$where;
        $query = $this->db->query($queryString);
        
        $this->addLog($queryString);
        
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public function search($sql, $search, $type = self::FETCH_ALL, $orderBy=false)
    {
        $where = $this->getPrepareWhereBySearch($search);
        
        if ($orderBy) {
            $where .= $where." ".$orderBy;
        }
        $queryString = $sql.$where;
        $query =  $this->db->query($queryString);
        
        $this->addLog($queryString);
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function insert($table, $values)
    {
        $sql = "INSERT INTO `".$table."` ";
        $prepareSql = $this->getPrepareByInsert($values);
        $sql = $sql.$prepareSql;
        
        $stm = $this->db->prepare($sql);
        //static::$db->beginTransaction();
        
        $this->addLog($sql);
        
        $stm->execute();
        
        //static::$db->commit();
        return $this->db->lastInsertId();
    }
    
    public function update($table, $search, $values)
    {
        $sql = "UPDATE `".$table."` ";
        $sql .= $this->getPrepareForUpdate($values);
        $sql .= $this->getPrepareWhereBySearch($search);
        
        $this->addLog($sql);
        
        return $this->db->query($sql);
    }
    
    public function delete($table, $search)
    {
        $sql = "DELETE FROM ".$table;
        $where = $this->getPrepareWhereBySearch($search);
        
        $sql = $sql.$where;
        
        $this->addLog($sql);
        
        $this->db->query($sql);
        
        return true;
    }
}
