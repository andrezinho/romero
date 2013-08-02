<?php
include_once("Main.php");
class UnidadMedida extends Main
{
    function indexGrid($page,$limit,$sidx,$sord)
    {
        $offset = ($page-1)*$limit;
        $query = "%".$query."%";

        $sql = "SELECT s.idunidad_medida,
                       s.descripcion,
                       s.simbolo,
                       case s.estado WHEN 1 then 'ACTIVO' else 'INCANTIVO' end
                FROM unidad_medida as s  ";    
        
        if($filtro!="") 
        $sql .= " where ".$filtro." ilike :query ";
        $sql .= " order by {$sidx} {$sord}
                 limit {$limit}
                 offset  {$offset} "; 
        
        $stmt = $this->db->prepare($sql);
        
        if($filtro!="") 
        $stmt->bindParam(':query',$query,PDO::PARAM_STR);
        $stmt->execute();
        
        $responce->records = $stmt->rowCount();
        $responce->page = $page;
        $responce->total = "1";        
        $i = 0;
        
        foreach($stmt->fetchAll() as $i => $row)
        {
            $responce->rows[$i]['id']=$row[0];
            $responce->rows[$i]['cell']=array($row[0],$row[1],$row[2]);
            $i ++;
        }
        return $responce;
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM unidad_medida WHERE idunidad_medida = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO unidad_medida (descripcion,simbolo, estado) VALUES(:p1,:p2,:p3)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['simbolo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE unidad_medida 
            set descripcion = :p1,
             simbolo = :p2,
            estado = :p3 
            WHERE 
            idunidad_medida = :idunidad_medida");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['simbolo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':idunidad_medida', $_P['idunidad_medida'] , PDO::PARAM_INT);
        //print_r($stmt);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM unidad_medida WHERE idunidad_medida = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>