<?php
include_once("Main.php");
class Consultas extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
       $sql = "SELECT
            a.idalmacen,
            a.descripcion,
            a.direccion,
            a.telefono,
            case a.estado when 1 then 'ACTIVO' else 'INCANTIVO' end            
            FROM
            produccion.almacenes AS a ";
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
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