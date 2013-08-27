<?php
include_once("Main.php");
class Clientes extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
        c.idcliente,
        c.dni,
        c.nombres || ' ' || c.apematerno || ' ' || c.apepaterno AS nombres,
        c.direccion,
        c.telefono,
        c.estadocivil,
        u.descripcion
        FROM
        cliente AS c
        INNER JOIN ubigeo AS u ON u.idubigeo = c.idubigeo ";

        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM cliente WHERE idcliente = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        /*$stmt = $this->db->prepare("INSERT INTO cliente(dni, razonsocial, 
                        replegal, telefono, direccion,contacto, email, estado,idubigeo,obs)
                values(:p1,:p2,:p3,:p5,:p6,:p7,:p8,:p9,:p10)");*/
        $stmt = $this->db->prepare("INSERT INTO cliente(dni, razonsocial, 
                        replegal, telefono, direccion,contacto, email, estado,obs,ruc,idubigeo)
                values(:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11)");
       
        $stmt->bindParam(':p1', $_P['dni'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['razonsocial'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['replegal'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['contacto'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['email'] , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p9', $_P['obs'] , PDO::PARAM_STR);
        $stmt->bindParam(':p10', $_P['ruc'] , PDO::PARAM_STR);
        $stmt->bindParam(':p11', $_P['iddistrito'] , PDO::PARAM_INT);
        //print_r($stmt);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }
    function update($_P ) 
    {
        $sql = "UPDATE cliente set 
                            dni=:p1,
                            razonsocial=:p2,
                            replegal=:p3,
                            telefono=:p4,
                            direccion=:p5,
                            contacto=:p6,
                            email=:p7,
                            estado=:p8,
                            ruc=:p9,
                            obs=:p10,
                            idubigeo= :p11
                    WHERE   idcliente = :idcliente ";
        $stmt = $this->db->prepare($sql);
                
        $stmt->bindParam(':p1', $_P['dni'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['razonsocial'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['replegal'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['contacto'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['email'] , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p9', $_P['ruc'] , PDO::PARAM_INT);
        $stmt->bindParam(':p10', $_P['obs'] , PDO::PARAM_STR);
        $stmt->bindParam(':p11', $_P['iddistrito'] , PDO::PARAM_INT);

        $stmt->bindParam(':idcliente', $_P['idcliente'] , PDO::PARAM_INT);

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM cliente WHERE idcliente = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function get($query,$field)
    {
        $query = "%".$query."%";
        $statement = $this->db->prepare("SELECT
                            c.idcliente,
                            c.dni,
                            c.nombres || ' ' || c.apepaterno || ' ' || c.apematerno AS nomcliente,
                            c.direccion,
                            c.telefono
                            FROM
                            cliente AS c
                        WHERE {$field} ilike :query and dni <> ''
                        limit 10");
        $statement->bindParam (":query", $query , PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
}
?>