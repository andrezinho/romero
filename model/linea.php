<?php
include_once("Main.php");
class Linea extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {

        $sql = "SELECT s.idlinea,
                       s.descripcion,
                       case s.estado when 1 then 'ACTIVO' else 'INCANTIVO' end
                from produccion.linea AS s";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM produccion.linea WHERE idlinea = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO produccion.linea (descripcion, estado) VALUES(:p1,:p2)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        //$id = $stmt->lastInsertId('produccion.linea_idlinea_seq');
        $p2 = $stmt->errorInfo();

        $stmt = $this->db->prepare("SELECT max(idlinea) as cod from produccion.linea");
        $stmt->execute();
        $row = $stmt->fetchObject();

        //$stmt

        return array($p1 , $p2[2], $row->cod);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE produccion.linea set descripcion = :p1, estado = :p2 WHERE idlinea = :idlinea");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':idlinea', $_P['idlinea'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM produccion.linea WHERE idlinea = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>