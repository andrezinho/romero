<?php
include_once("Main.php");

class Tipodocumento extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)    
    {
        $sql = "SELECT
            t.idtipodocumento,
            t.descripcion,
            t.abreviado,
            tp.descripcion,
            case t.estado when 1 then 'ACTIVO' else 'INCANTIVO' end
            FROM
            facturacion.tipodocumento AS t
            INNER JOIN facturacion.tipdoc AS tp ON tp.idtipdoc = t.idtipdoc ";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM facturacion.tipodocumento WHERE idtipodocumento = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO facturacion.tipodocumento (descripcion, 
                        abreviado,idtipdoc, estado) 
                    VALUES(:p1,:p2,:p3,:p4)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['abreviado'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['idtipdoc'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['activo'] , PDO::PARAM_INT);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE facturacion.tipodocumento 
            set 
            descripcion = :p1, 
            abreviado = :p2,
            idtipdoc = :p3,
            estado = :p4 

            WHERE idtipodocumento = :idtipodocumento");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['abreviado'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['idtipdoc'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['activo'] , PDO::PARAM_INT);

        $stmt->bindParam(':idtipodocumento', $_P['idtipodocumento'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM facturacion.tipodocumento WHERE idtipodocumento = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>