<?php
include_once("Main.php");
class TipoCliente extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            t.idtipos_clientes,
            t.descripcion,
            t.estado
            FROM
            tipos_clientes AS t";
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM tipos_clientes WHERE idtipos_clientes = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT INTO tipos_clientes(descripcion,estado)
                                    values(:p1,:p2) ");
               
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);    
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);        
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }

    function update($_P ) 
    {
        $sql = "UPDATE tipos_clientes 
                set  descripcion=:p1,                    
                    estado=:p2
                                   
                WHERE idtipos_clientes = :idtipos_clientes";
        $stmt = $this->db->prepare($sql);
            
            $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);            
            $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);
            
            $stmt->bindParam(':idtipos_clientes', $_P['idtipos_clientes'] , PDO::PARAM_INT);


        $p1 = $stmt->execute();

        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM tipos_clientes WHERE idtipos_clientes = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>