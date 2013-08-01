<?php
include_once("Main.php");
class Madera extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query)
    {
        $offset = ($page-1)*$limit;
        $query = "%".$query."%";
        $sql = "SELECT
            m.idmadera,
            m.tipoproducto,
            m.idtipomadera,
            m.precio_unitario,
            m.idunidad_medida,
            m.stock,
            case m.estado when 1 then 'ACTIVO' else 'INACTIVO' end,            
            t.descripcion,
            u.descripcion
            FROM
            produccion.madera AS m
            INNER JOIN produccion.tipomadera AS t ON t.idtipomadera = m.idtipomadera
            INNER JOIN public.unidad_medida AS u ON u.idunidad_medida = m.idunidad_medida ";

        if($filtro!="") $sql .= " where ".$filtro." ilike :query ";

        $sql .= " order by {$sidx} {$sord}
                 limit {$limit}
                 offset  {$offset} "; 
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':query',$query,PDO::PARAM_STR);
        $stmt->execute();
        
        $responce->records = $stmt->rowCount();
        $responce->page = $page;
        $responce->total = "1";        
        $i = 0;
        foreach($stmt->fetchAll() as $i => $row)
        {
            $responce->rows[$i]['id']=$row[0];
            $responce->rows[$i]['cell']=array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8]);
            $i ++;
        }
        return $responce;
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM produccion.madera WHERE idmadera = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT into produccion.madera(tipoproducto,idtipomadera,
                                    precio_unitario,idunidad_medida,stock,estado)
                                    values(:p1,:p2,:p3,:p5,:p6,:p7)");
              
        $stmt->bindParam(':p1', $_P['tipoproducto'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['idtipomadera'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['precio_unitario'] , PDO::PARAM_INT);        
        $stmt->bindParam(':p5', $_P['idunidad_medida'] , PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_P['stock'] , PDO::PARAM_INT);
        $stmt->bindParam(':p7', $_P['activo'] , PDO::PARAM_INT);
        
                
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }
    function update($_P ) 
    {
        $sql = "UPDATE produccion.madera 
                    set     tipoproducto=:p1,
                            idtipomadera=:p2,
                            precio_unitario=:p3,
                            idunidad_medida=:p5,
                            stock=:p6,
                            estado=:p7

                       where idmadera = :idmadera";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':p1', $_P['tipoproducto'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['idtipomadera'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['precio_unitario'] , PDO::PARAM_INT);        
        $stmt->bindParam(':p5', $_P['idunidad_medida'] , PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_P['stock'] , PDO::PARAM_INT);
        $stmt->bindParam(':p7', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':idmadera', $_P['idmadera'] , PDO::PARAM_INT);            
            
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM produccion.madera WHERE idmadera = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>