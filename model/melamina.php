<?php
include_once("Main.php");
class Melamina extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query)
    {
        $offset = ($page-1)*$limit;
        $query = "%".$query."%";
        $sql = "SELECT
            me.idmelamina,
            li.descripcion,
            ma.descripcion,
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

        if($filtro!="") 
        $sql .= " where ".$filtro." ilike :query ";
        $sql .= " order by {$sidx} {$sord}
                 limit {$limit}
                 offset  {$offset} "; 
        
        $stmt = $this->db->prepare($sql);
        
        if($filtro!="") 
        $stmt->bindParam(':query',$query,PDO::PARAM_STR);
        $stmt->execute();
        
        $responce->records = $stmt->rowCount();
        $responce->page = $page;
        $responce->total = "1";        
        $i = 0;
        foreach($stmt->fetchAll() as $i => $row)
        {
            $responce->rows[$i]['id']=$row[0];
            $responce->rows[$i]['cell']=array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9]);
            $i ++;
        }
        return $responce;
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
}
?>