<?php
include_once("Main.php");
class Melamina extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        
        $sql = "SELECT
            me.idmelamina,
            li.descripcion,
            ma.descripcion || ' - ' || ma.espesor,
            me.medidas,
            me.peso_unitario,
            me.precio_unitario,           
            un.simbolo,
            case me.estado when 1 then 'ACTIVO' else 'INCANTIVO' end,            
            me.stock,
            me.igv,
            me.tipoproducto       
            
            FROM
            produccion.melamina AS me
            INNER JOIN produccion.linea AS li ON li.idlinea = me.idlinea
            INNER JOIN produccion.maderba AS ma ON ma.idmaderba = me.idmaderba
            INNER JOIN public.unidad_medida AS un ON un.idunidad_medida = me.idunidad_medida ";

        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM produccion.melamina WHERE idmelamina = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT into produccion.melamina(idlinea,idmaderba,medidas,peso_unitario,
                                precio_unitario,igv,tipoproducto,stock,idunidad_medida,estado)
                        values(:p1,:p2,:p3,:p4,:p5,:p6,2,:p8,:p9,:p10)");
              
        $stmt->bindParam(':p1', $_P['idlinea'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['idmaderba'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['medidas'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p4', $_P['peso_unitario'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['precio_unitario'] , PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_P['igv'] , PDO::PARAM_INT);
        
        $stmt->bindParam(':p8', $_P['stock'] , PDO::PARAM_INT);
        $stmt->bindParam(':p9', $_P['idunidad_medida'] , PDO::PARAM_INT);
        $stmt->bindParam(':p10', $_P['activo'] , PDO::PARAM_INT);        
                
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }

    function update($_P ) 
    {
        $sql = "UPDATE produccion.melamina SET
                    idlinea=:p1,
                    idmaderba=:p2,
                    medidas=:p3,
                    peso_unitario=:p4,
                    precio_unitario=:p5,
                    igv=:p6,
                    
                    stock=:p8,
                    idunidad_medida=:p9,
                    estado=:p10

                WHERE idmelamina = :idmelamina";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':p1', $_P['idlinea'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['idmaderba'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['medidas'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p4', $_P['peso_unitario'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['precio_unitario'] , PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_P['igv'] , PDO::PARAM_INT);        
        $stmt->bindParam(':p8', $_P['stock'] , PDO::PARAM_INT);
        $stmt->bindParam(':p9', $_P['idunidad_medida'] , PDO::PARAM_INT);
        $stmt->bindParam(':p10', $_P['activo'] , PDO::PARAM_INT);

        $stmt->bindParam(':idmelamina', $_P['idmelamina'] , PDO::PARAM_INT);            
            
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM produccion.melamina WHERE idmelamina = :p1");
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
            $data[] = array('idmelamina'=>$r[0],'descripcion'=>$r[1]);
        }
        return $data;
    }
}
?>