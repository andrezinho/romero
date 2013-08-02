<?php
include_once("Main.php");
class Madera extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            m.idmadera,
            m.descripcion,
            u.descripcion,
            m.precio_unitario,
            m.stock,
            case m.estado when 1 then 'ACTIVO' else 'INACTIVO' end ,
            m.tipoproducto,      
            m.idunidad_medida                     
            
            FROM
            produccion.madera AS m
            INNER JOIN public.unidad_medida AS u ON u.idunidad_medida = m.idunidad_medida ";
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM produccion.madera WHERE idmadera = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT into produccion.madera(tipoproducto,descripcion,
                                    precio_unitario,idunidad_medida,stock,estado)
                                    values(:p1,:p2,:p3,:p5,:p6,:p7)");
              
        $stmt->bindParam(':p1', $_P['tipoproducto'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
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
                            descripcion=:p2,
                            precio_unitario=:p3,
                            idunidad_medida=:p5,
                            stock=:p6,
                            estado=:p7

                       where idmadera = :idmadera";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':p1', $_P['tipoproducto'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
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