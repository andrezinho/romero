<?php
include_once("Main.php");
class Melamina extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        
        $sql = "SELECT
            p.idproducto,
            p.descripcion,
            m.descripcion || ' - ' || l.descripcion AS carac,
            p.medidas,
            p.precio_u,
            p.stock,
            u.simbolo,
            case p.estado when 1 then 'ACTIVO' else 'INCANTIVO' end            
            FROM
            produccion.producto AS p
            INNER JOIN unidad_medida AS u ON u.idunidad_medida = p.idunidad_medida
            INNER JOIN produccion.maderba AS m ON m.idmaderba = p.idmaderba
            INNER JOIN produccion.linea AS l ON l.idlinea = m.idlinea

            WHERE p.idtipoproducto=2 ";

        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT
                    p.idproducto,
                    p.idmaderba,
                    m.idlinea,
                    p.medidas,
                    p.precio_u,
                    p.stock,
                    p.idunidad_medida,
                    p.estado
                    FROM
                    produccion.linea AS l
                    INNER JOIN produccion.maderba AS m ON l.idlinea = m.idlinea
                    INNER JOIN produccion.producto AS p ON m.idmaderba = p.idmaderba
                    WHERE
                    p.idtipoproducto=2 AND idproducto = :id ");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {

        $tipopro=2;      
        $Des='MELAMINA';
        $stmt = $this->db->prepare("INSERT INTO produccion.producto(
            idtipoproducto, descripcion, idmaderba, medidas, 
            precio_u, stock, idunidad_medida, estado)

            VALUES(:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8)");
              
        $stmt->bindParam(':p1', $tipopro , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $Des , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['idmaderba'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p4', $_P['medidas'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['precio_u'] , PDO::PARAM_INT);     
        $stmt->bindParam(':p6', $_P['stock'] , PDO::PARAM_INT);
        $stmt->bindParam(':p7', $_P['idunidad_medida'] , PDO::PARAM_INT);
        $stmt->bindParam(':p8', $_P['activo'] , PDO::PARAM_INT);        
                
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }

    function update($_P ) 
    {
        $sql = "UPDATE produccion.producto 
                SET
                    
                    idmaderba=:p3,
                    medidas=:p4,
                    precio_u=:p5,
                    stock=:p6,
                    idunidad_medida=:p7,                    
                    estado=:p8

                WHERE idproducto = :idproducto";

        $stmt = $this->db->prepare($sql);

        //$stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['idmaderba'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p4', $_P['medidas'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['precio_u'] , PDO::PARAM_INT);     
        $stmt->bindParam(':p6', $_P['stock'] , PDO::PARAM_INT);
        $stmt->bindParam(':p7', $_P['idunidad_medida'] , PDO::PARAM_INT);
        $stmt->bindParam(':p8', $_P['activo'] , PDO::PARAM_INT);

        $stmt->bindParam(':idproducto', $_P['idproducto'] , PDO::PARAM_INT);            
            
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM produccion.producto WHERE idproducto = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function getList($idl=null)
    {
        $sql = "SELECT * from produccion.vista_melamina ";
        if($idl!=null)
        {
            $sql .= " WHERE idlinea = {$idl}";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = array();
        foreach($stmt->fetchAll() as $r)
        {
            $data[] = array('idproducto'=>$r[0],'descripcion'=>$r[1]);
        }
        return $data;
    }
    
    function getPrice($id)
    {
        $stmt = $this->db->prepare("SELECT precio_u from produccion.producto WHERE idproducto = :p1");
        $stmt->bindParam(':p1', $id, PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchObject();
        return $r->precio_u;
    }

    function getStock($id,$a)
    {
        $sql = "SELECT t.idm,t.c,t.item
                from (
                SELECT max(idmovimiento) as idm ,ctotal_current as c, item
                FROM movimientosdetalle
                where idtipoproducto = 2 and idproducto = :idp and idalmacen = :ida 
                group by ctotal_current,item,idmovimiento
                order by idmovimiento desc
                limit 1) as t
                order by t.item desc ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idp',$id,PDO::PARAM_INT);
        $stmt->bindParam(':ida',$a,PDO::PARAM_INT); 
        $stmt->execute();
        $row = $stmt->fetchObject();
        if($row->c>0)
            return $row->c;
        else return '0.000';
    }
}
?>