<?php
include_once("Main.php");
class Caja extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            c.idcaja,
            c.nombre,
            c.descripcion,
            case c.estado when 1 then 'ACTIVO' else 'INCANTIVO' end          
            
            FROM
            facturacion.caja AS c ";    
            
            return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM facturacion.caja WHERE idcaja = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO facturacion.caja (nombre,descripcion, estado) 
                    VALUES(:p1,:p2,:p3)");
        $stmt->bindParam(':p1', $_P['nombre'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);
        //$stmt->bindParam(':p4', $_P['idarea'] , PDO::PARAM_INT);

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        $stmt = $this->db->prepare("SELECT max(idcaja) as cod from facturacion.caja");
        $stmt->execute();
        $row = $stmt->fetchObject();
        return array($p1 , $p2[2]);
        //return array($p1 , $p2[2], $row->cod, $_P['nombre']. ' - '.$_P['descripcion']);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE facturacion.caja 
                set nombre = :p1, 
                descripcion= :p2, 
                estado = :p3
                
                
                WHERE idcaja = :idcaja");
        $stmt->bindParam(':p1', $_P['nombre'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);
        //$stmt->bindParam(':p4', $_P['idarea'] , PDO::PARAM_INT);

        $stmt->bindParam(':idcaja', $_P['idcaja'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM facturacion.caja WHERE idcaja = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>