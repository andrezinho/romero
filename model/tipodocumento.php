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

    public function GCorrelativo($idtp)
    {
        $sql = "SELECT            
                    c.serie,
                    c.numero            
                    FROM
                    facturacion.correlativo AS c
                    INNER JOIN facturacion.tipodocumento AS t ON t.idtipodocumento = c.idtipodocumento
                    WHERE c.idtipodocumento='$idtp' AND c.estado=1 and c.idsucursal = ".$_SESSION['idsucursal'];    
        $stmt=$this->db->prepare($sql);
        $stmt->execute();
        $data = array();
        $row= $stmt->fetchObject();

        $Serie = $row->serie;
        $Serie= str_pad($Serie, 4, "000", STR_PAD_LEFT);

        $Num =$row->numero;
        $Num= str_pad($Num, 6,"00000", STR_PAD_LEFT);

        $data = array('serie'=>$Serie,'numero'=>$Num);
        return $data;
    }

    public function UpdateCorrelativo($idtp)
    {
        $s = $this->db->prepare("SELECT * from facturacion.correlativo where idtipodocumento = :id and idsucursal = :ids");
        $s->bindParam(':id',$idtp,PDO::PARAM_INT);
        $s->bindParam(':ids',$_SESSION['idsucursal'],PDO::PARAM_INT);
        $s->execute();
        $r = $s->fetchObject();
        $vserie = $r->serie;
        if($r->numero>=$r->valormaximo)
            {$vs = $r->valorminimo;$vserie=$r->serie+1;}
        else 
            {$vs = $r->numero+$r->incremento;}
        $s = $this->db->prepare("UPDATE facturacion.correlativo set numero = {$vs} , serie = {$vserie}
                                where idtipodocumento = :id and idsucursal = :ids");
        $s->bindParam(':id',$idtp,PDO::PARAM_INT);
        $s->bindParam(':ids',$_SESSION['idsucursal'],PDO::PARAM_INT);
        $s->execute();
    }
}
?>