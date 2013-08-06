<?php
include_once("Main.php");
class Proveedor extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            p.idproveedor,
            p.ruc,
            p.razonsocial,
            p.dni,
            p.replegal,
            p.telefono,            
            p.direccion,
            u.descripcion,
            p.estado,
            p.email,
            p.obs,            
            p.contacto,
            p.idubigeo
            
            FROM
            public.proveedor AS p
            INNER JOIN public.ubigeo AS u ON u.idubigeo = p.idubigeo ";

        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM proveedor WHERE idproveedor = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT INTO proveedor(dni, razonsocial, 
                        replegal, telefono, direccion,contacto, email, estado,idubigeo,obs)
                values(:p1,:p2,:p3,:p5,:p6,:p7,:p8,:p9,:p10)");
             
        $stmt->bindParam(':p1', $_P['dni'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['razonsocial'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['replegal'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['contacto'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['email'] , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p9', $_P['idubigeo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p10', $_P['obs'] , PDO::PARAM_STR);

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }
    function update($_P ) 
    {
        $sql = "UPDATE proveedor set 
                            dni=:p1,
                            razonsocial=:p2,
                            replegal=:p3,
                            telefono=:p4,
                            direccion=:p5,
                            contacto=:p6,
                            email=:p7,
                            estado=:p8,
                            idubigeo=:p9,
                            obs=:p10
                       where idproveedor = :idproveedor";
        $stmt = $this->db->prepare($sql);
                
        $stmt->bindParam(':p1', $_P['dni'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['razonsocial'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['replegal'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['contacto'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['email'] , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p9', $_P['idubigeo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p10', $_P['obs'] , PDO::PARAM_STR);

        $stmt->bindParam(':idproveedor', $_P['idproveedor'] , PDO::PARAM_INT);

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM proveedor WHERE idproveedor = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>