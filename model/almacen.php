<?php
include_once("Main.php");
class Almacen extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query)
    {
        $offset = ($page-1)*$limit;
        $query = "%".$query."%";
        $sql = "SELECT
            a.idalmacen,
            a.descripcion,
            a.direccion,
            a.telefono,
            case a.estado when 1 then 'ACTIVO' else 'INCANTIVO' end
            
            FROM
            produccion.almacenes AS a ";
        //print_r($sql);
        if($filtro!="") $sql .= " WHERE ".$filtro." ilike :query ";
        //$sql .= " where cast(".$filtro." as varchar) ilike :query ";

        $sql .= " order by {$sidx} {$sord}
                 limit {$limit}
                 offset  {$offset} "; 
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':query',$query,PDO::PARAM_STR);
        $stmt->execute();
        
        $responce->records = $stmt->rowCount();
        $responce->page = $page;
        $responce->total = "1";        
        $i = 0;
        foreach($stmt->fetchAll() as $i => $row)
        {
            $responce->rows[$i]['id']=$row[0];
            $responce->rows[$i]['cell']=array($row[0],$row[1],$row[2],$row[3],$row[4]);
            $i ++;
        }
        return $responce;
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM produccion.almacenes WHERE idalmacen = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT INTO produccion.almacenes(descripcion,direccion,telefono,estado)
                                    values(:p1,:p2,:p3,:p4) ");
        //if($_P['descripcion']==""){$_P['descripcion']=null;}        
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);       
        $stmt->bindParam(':p2', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['telefono'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['activo'] , PDO::PARAM_INT);        
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }

    function update($_P ) 
    {
        $sql = "UPDATE produccion.almacenes 
                set descripcion=:p1,
                    direccion=:p2,
                    telefono=:p3,
                    estado =:p4             
                WHERE idalmacen = :idalmacen ";
        $stmt = $this->db->prepare($sql);
            
            $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $_P['direccion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p3', $_P['telefono'] , PDO::PARAM_STR);
            $stmt->bindParam(':p4', $_P['activo'] , PDO::PARAM_INT); 

            $stmt->bindParam(':idalmacen', $_P['idalmacen'] , PDO::PARAM_INT);


        $p1 = $stmt->execute();

        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM produccion.almacenes WHERE idalmacen = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>