<?php
include_once("Main.php");
class Maderba extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT s.idmaderba,
                       s.descripcion,
                       s.espesor,
                       case s.estado when 1 then 'ACTIVO' else 'INCANTIVO' end
                FROM produccion.maderba AS s";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM produccion.maderba WHERE idmaderba = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO produccion.maderba (descripcion,espesor, estado) VALUES(:p1,:p2,:p3)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['espesor'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE produccion.maderba 
                set descripcion = :p1, espesor= :p2, estado = :p3 
                WHERE idmaderba = :idmaderba");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['espesor'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':idmaderba', $_P['idmaderba'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM produccion.maderba WHERE idmaderba = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>